<?php

namespace App\Services;

use App\Entities\Inventory;
use App\Models\InventoryModel;
use App\Models\StoreModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;
use Config\Database;
use Config\Services;
use JetBrains\PhpStorm\NoReturn;

class InventoryService
{
    protected InventoryModel $inventory;
    protected string $reason = '';
    protected array $decreasedInventory = [];
    private CONST NOT_ENOUGH_STOCK = 'No tiene suficiente stock';
    private mixed $qtyToRollback;

    /**
     * @param InventoryModel $inventoryModel
     */
    public function __construct(\App\Models\InventoryModel|null $inventoryModel = null)
    {
        $this->inventory = $inventoryModel ?? new InventoryModel();
    }
    
    public function getAll()
    {
        return $this->inventory->findAll();
    }


    /**
     * @throws \ReflectionException
     * @throws  DatabaseException
     */
    public function setInventory(Inventory $inventory,$request): array|bool
    {
        $inventory->fill([
            "code"=> $this->generateCode($inventory),
            "enter_at"=>Time::now()

        ]);

        return $this->inventory->save($inventory)?:$this->inventory->errors();

    }
    public function generateCode($inventory): string
    {
        $idStore = $inventory->store ;
       $store =  model(StoreModel::class)->find($idStore);
       return  str_replace(" ","",$store->name) .str_pad( $inventory->item,5,'0',STR_PAD_LEFT);

    }
     public function getInventory(int $store = 0 ,int|string|null $field=null,  $id = 0, $sum =false ): string|array|null|Inventory
     {
         
         $this->inventory
             ->select(["inventories.id",
                 " inventories.code",
                 "inventories.item item",
                 "store",
                 "items.name as item_name",
                 "items.`key` as item_key",
                 "items.barcode"
             ])
             ->join("items","on inventories.item = items.id","left")
             ->orderBy("enter_at","ASC");

         if($store!== 0 ){
             $this->inventory->where("store",$store);
         }

         if ( !is_null($id) && $id !=='') {
             $this->inventory
                 ->where([$field=> $id]);
         }

         if ($sum) {
             if(!is_null($field) && $field !== ''){
                 $this->inventory->groupBy($field);
             }

             $inventory =$this->inventory
                 ->selectSum("inventories.stock")->groupBy("code")
                 
                 ->findAll()??["code"=>null,"item"=>intval($id),"store"=>$store,"stock"=>0];
                 
         }else{
             $inventory = $this->inventory
                 ->select("inventories.id,stock,bill,enter_at")
                 ->findAll();
         }
         return $inventory;
     }

     public function decrease(Inventory|array $inventory, ?int $toDecrease):bool
     {
         $this->qtyToRollback = $toDecrease;
         $today = Time::now()->toDateTimeString();
         $decreased = false ;

         if($inventory instanceof Inventory)
         {
             if($inventory->stock >= $toDecrease)
             {
                 $currentStock = $this->currentStock($inventory, $toDecrease);
                 $inventory->fill([
                     "stock"=> $currentStock,
                     "updated_at"=>$today
                 ]);
                 try {
                     $decreased = $this->inventory->save($inventory);
                     $currentStock >1 ?:$this->inventory->delete($inventory->id);
                 } catch (\ReflectionException $e) {

                     $this->reason = $e->getMessage();

                 }
             }else{
                 $this->reason = self::NOT_ENOUGH_STOCK;
                 return false;
             }
             $this->decreasedInventory[] = $inventory;

         }
         else{
             $stock = $this->getStockTotal($inventory);


             if($toDecrease > $stock){

                 $this->reason = self::NOT_ENOUGH_STOCK;
                 return false;
             }
             
            $updateBatch = [];
            foreach($inventory as $key => $finalInventory )
            {
                if($toDecrease > 0 ){
                    if($finalInventory->stock >= $toDecrease)
                    {

                        $currentStock = $this->currentStock($finalInventory ,$toDecrease);

                        $finalInventory->fill([
                            "stock"=>$currentStock,
                            "updated_at"=>$today,
                            "decreased"=>$toDecrease,
                        ]);
                        $currentStock > 0 || $this->deleteInventory($finalInventory);
                        
                        $updateBatch[] = $finalInventory;
                        $toDecrease = 0;
                        
                       
                    }else{
                        $toDecrease = $toDecrease-$finalInventory->stock;
                        
                        $finalInventory->fill([
                            "stock"=>0,
                            "updated_at"=>$today,
                            "decreased"=>$finalInventory->stock,
                        ]);
                        $updateBatch[] = $finalInventory;
                        $this->inventory->delete($finalInventory->id);
                      

                    }
                    $this->decreasedInventory[] = $finalInventory;
                }
            }
            try {
                $rows =  $this->inventory->updateBatch($updateBatch, "id");
                $decreased = $rows>0;
               
             } catch (\ReflectionException $e) {
                $this->reason = $e->getMessage();
                return false;
             }

         }
         return $decreased;
     }

     public function getReason()
     {
         return $this->reason;
     }
     private function currentStock(Inventory $inventory,$toDecrease): int
     {
         return $inventory->stock - $toDecrease;
     }
     public function getDecreasedId(): array
     {
         return $this->decreasedInventory;
     }
     public function resetDecreased()
     {
          $this->decreasedInventory = [];
          $this->qtyToRollback = 0;
     }
     public function rollback(?array $saleItems =[]): bool
     {
         $updated = false;
         if(empty($saleItems)) {
             foreach ($this->decreasedInventory as $inventory) {
                 try {
                     $updated = $this->inventory
                         ->set([
                             "stock" => $this->qtyToRollback + $inventory->stock,
                             "updated_at" => Time::now()
                         ])
                         ->update($inventory->id);
                 } catch (\ReflectionException $e) {
                     $this->reason = $e->getMessage();
                     return false;
                 }
             }
         }else{
             foreach ($saleItems as $saleItem) {
                 $currentInventory = $this->inventory->withDeleted()->find($saleItem->inventory);
                 $newStock =$this->currentStock($currentInventory,(-1*$saleItem->qty));
                 $deleted_at = $newStock >0&& !is_null($currentInventory->deleted_at)?null:$currentInventory->deleted_at;
                 try {
                     $updated = $this->inventory
                         ->set([
                             "stock" => $newStock,
                             "updated_at" => Time::now()->toDateTimeString(),
                             "deleted_at" => $deleted_at
                         ])->update($saleItem->inventory);
                 } catch (\ReflectionException $e) {
                     $this->reason = $e->getMessage();
                     return false;
                 }
                 
             }
         }
         return $updated;
     }
     public function getErrors(): ?array
     {
         return $this->inventory->errors();
     }
     
     private function getStockTotal($inventory): int
     {
         $stock = 0;
         foreach ($inventory as $inventoryItem) {
             $stock += $inventoryItem->stock;
         }
         return $stock;
     }
     
     
     public function deleteInventory(Inventory|array $inventory):bool
     {
         if($inventory instanceof Inventory)
         {
             $deleted = $this->inventory->delete($inventory->id);
         }else{
             foreach($inventory as $inventoryItem)
             {
                 $id = $inventoryItem->id;
                 $deleted = $this->inventory->delete($id);
             }
         }
         return $deleted;
     }
     
     public function inventoryCost(): array|object
     {
         $store = session("store");
         try {


             $costs = $this->inventory
                 ->select([
                     "sum(it.cost  * inventories.stock) as cost",
                     "sum(ip.amount  * inventories.stock) as public_price",
                     "0 as discount_price",

                 ])
                 ->where("inventories.store", $store->id)
                 ->join("items it", "inventories.item=it.id")
                 ->join("item_prices ip", "it.id=ip.item and ip.type = 'regular'", "left")
                 ->first();
         }catch (DatabaseException $e) {
             $costs  = [];
         }
         return  $costs;
     }
}

