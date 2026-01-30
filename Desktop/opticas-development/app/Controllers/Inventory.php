<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Services\InventoryService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;


class Inventory extends BaseController
{
    use ResponseTrait;
    
    protected InventoryModel $inventoryModel;
    protected InventoryService $inventoryService;
    public function __construct()
    {
        $this->inventoryModel = new InventoryModel();
        $this->inventoryService = new InventoryService($this->inventoryModel);
    }
    
    public function index()
    {

        $inventory = $this->inventoryModel
            ->select("inventories.*,articles.id item, articles.name item_name")
            ->join("articles", "articles.id = inventories.item")
            ->withDeleted()
            ->findAll();
        return $this->respond($inventory);
    }
    public function show($id): ResponseInterface
    {
        return $this->respond($this->inventoryModel->find($id));
    }
    public function create(): ResponseInterface
    {
        $inventory = new \App\Entities\Inventory($this->request->getPost());

        try {

            $saved = $this->inventoryService->setInventory($inventory,$this->request);// $this->inventoryModel->save($inventory);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        } catch (DatabaseException $exception)
        {
            return $this->fail("Estamos presentando problemas al conectar con la base de datos.");
        }

        return $saved ?
            $this->respondCreated($this->inventoryModel->find($this->inventoryModel->getInsertID())):
            $this->fail($this->inventoryModel->errors());


    }

    public function purchase(): void
    {
        $purchaseDate = new Time($this->request->getPost('date'));

        $this->logger->info($purchaseDate->toDateTimeString());
    }
    public function inventory($store,$field=null,$id= null ): ResponseInterface
    {
        helper("url");
        $allowedFields = $this->inventoryModel->getAllowedFields();
        $fieldExist = in_array($field,$allowedFields);
       if(!$fieldExist && $field!==''){
           return $this->fail("Field not allowed",ResponseInterface::HTTP_BAD_REQUEST);
       }
       $sum = current_url(true)->getSegment(1)==="stock";
       $inventory = $this->inventoryService->getInventory($store,$field, $id, $sum);
       
       return $this->respond($inventory);

    }
    
    public function update($id)
    {
        $inventory = $this->inventoryModel->find($id);
        $newInventory = $this->request->getRawInput();
        $newInventory["inventory"]["updated_at"] = Time::today()->toDateTimeString();
        $inventory->fill($newInventory["inventory"]);
        try {
            if($inventory->stock === 0 ){
                $updated = $this->inventoryModel->delete($inventory->id);
            }else{

                $updated = $this->inventoryModel->save($inventory);
            }
        } catch (\ReflectionException $e) {
            $errors = $e->getMessage();
        }
        return $updated  ?  $this->respondUpdated($inventory):$this->fail([$this->inventoryModel->errors(),$errors]);
        
    }
    public function delete($item)
    {
        $inventory = $this->inventoryModel->find($item);
        $deleted = $this->inventoryModel->delete($inventory->id);
        return $deleted  ?  $this->respondDeleted($inventory):$this->fail($this->inventoryModel->errors());
    }
}
