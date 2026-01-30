<?php
namespace App\Services;

use App\Entities\Sale;
use App\Entities\SaleItem;
use App\Models\ItemModel;
use App\Models\SaleItemsModel;
use App\Models\SaleModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Throwable;

class SaleItemService
{
  
    protected SaleItemsModel $saleItemsModel;
    protected array $errors = [];
    
    public function __construct()
    {
        $this->saleItemsModel = new SaleItemsModel();
        
    }
    
    /**
     * @throws \ReflectionException
     */
    public function setSaleItems(Sale $sale, array $cart): array | false
    {
        $inventoryService = new InventoryService();
        $cart = array_filter($cart);
        $items = [];
        $decreased = false;
        foreach($cart as $key => $patient)
        {
            if(!isset($patient["items"]))continue;
            foreach ($patient["items"] as $key => $item)
            {
                $dbItem = model(ItemModel::class)->find($item["id"]);
                if (!$dbItem) {
                    return false;
                }

                $isLens = method_exists($dbItem, 'isLens')
                    ? $dbItem->isLens()
                    : ($dbItem->line == 13); // fallback por línea de lentes


                if(!$dbItem->isStockable())
                {



                    $singleItem = new SaleItem([
                        "sale" => $sale->id,
                        "patient" => $patient["id"]===''?null:$patient["id"],
                        "prescription" => $patient["prescription"]??null,
                        "store"=>session("store")->id,
                        "qty"=>$item["qty"],
                        "item" => $item["id"],
                        "inventory" =>null,
                        "sale_price" => $item["price"],
                        "base_unit_price" => $dbItem->unit_price,
                        "unit_price" => $isLens && ($item["lens_side"] ?? 'pair') !== 'pair'
                            ? $item["unit_price"]
                            : $dbItem->unit_price,
                        "lens_side" => $isLens ? ($item["lens_side"] ?? 'pair') : null,
                        "is_partial" => $isLens && ($item["lens_side"] ?? 'pair') !== 'pair',
                        "final_price" => $item["qty"] * (
                            $isLens && ($item["lens_side"] ?? 'pair') !== 'pair'
                                ? $item["unit_price"]
                                : $dbItem->unit_price
                        ),
                    ]);

                    $items[] = $singleItem;

                    continue;
                }

                $itemStock = $inventoryService->getInventory($sale->store,"item",$item["id"]);
                $decreased = $inventoryService->decrease($itemStock,(int)$item["qty"]);


                if ($decreased) {

                    $decreasedIds= $inventoryService->getDecreasedId();


                    foreach ($decreasedIds as $key => $inventoryDecreased)
                    {
                        if($inventoryDecreased->item==$item["id"]) {
                            $singleItem = new SaleItem([
                                "sale" => $sale->id,
                                "patient" => $patient["id"]===''?null:$patient["id"],
                                "prescription" => $patient["prescription"]??null,
                                "store"=>session("store")->id,
                                "qty"=>$inventoryDecreased->decreased,
                                "item" => $item["id"],
                                "inventory" => $inventoryDecreased->id,
                                "sale_price" => $item["price"],
                                "base_unit_price" => $dbItem->unit_price,
                                "unit_price" => $isLens && ($item["lens_side"] ?? 'pair') !== 'pair'
                                    ? $item["unit_price"]
                                    : $dbItem->unit_price,
                                "lens_side" => $isLens ? ($item["lens_side"] ?? 'pair') : null,
                                "is_partial" => $isLens && ($item["lens_side"] ?? 'pair') !== 'pair',
                                "final_price" => $inventoryDecreased->decreased * (
                                    $isLens && ($item["lens_side"] ?? 'pair') !== 'pair'
                                        ? $item["unit_price"]
                                        : $dbItem->unit_price
                                ),
                            ]);

                            $items[] = $singleItem;
                        }
                    }
                    $inventoryService->resetDecreased();

                }else{
                    return false;
                }
            }
        }

        try{
            $saleItems= $this->saleItemsModel->insertBatch($items);
        }catch(\ReflectionException | DatabaseException $e){
            $this->errors[] = $e->getMessage();
        }

        $inserted =( $decreased && count($items) > 0 )&& $saleItems>0 ;

        return $inserted && $decreased ?
            $this->saleItemsModel
                ->where(["sale"=>$sale->id])
                ->findAll() :
           false;
    }
    
    public function getSaleItems(Sale $sale,$withItem =false): ?array
    {
        if($withItem)
        {
            $this->saleItemsModel->select(["sale_items.*","sale_items.item as item_obj"]);
        }
        return $this->saleItemsModel->where(["sale"=>$sale->id])->findAll();
    }

    public function getSaleLens(...$params): array
    {
        if(!empty($params[0])) {
            return $this->saleItemsModel
                ->select(["items.*"])
                ->where($params[0])
                ->join("items", "items.id = sale_items.item AND items.line = 13")
                ->findAll();

        }
        else{
            return [];
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}




