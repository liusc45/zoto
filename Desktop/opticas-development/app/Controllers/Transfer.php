<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransferModel;
use App\Services\InventoryService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Transfer extends BaseController
{
    use ResponseTrait;
    protected TransferModel $transferModel;
    protected InventoryService $inventoryService;
    public function __construct()
    {
        $this->transferModel = new TransferModel();
        $this->inventoryService = new InventoryService();
    }

    public function index(): ResponseInterface
    {
        $select = [
            "transfers.id",
            "transfers.qty",
            "transfers.created_at",
            "items.name as article",
            "st.name as dispatch",
            "sr.name as receive",
            "u.username as transfered_by"
        ];
        $transfers = $this->transferModel
            ->select($select)
            ->join("items", "items.id = transfers.item")
            ->join("stores st", "st.id = transfers.store_dispatch")
            ->join("stores sr", "sr.id = transfers.store_receive")
            ->join("users u", "u.id = transfers.created_by")
            ->findAll();
        return $this->respond($transfers);
    }
    public function show($id): ResponseInterface
    {
        return $this->respond($this->transferModel->find($id));
    }

    public function create(): ResponseInterface
    {
        if(!in_array("admin",auth()->user()->getGroups()))
        {
            $this->logger->error("Insufficient permissions! ".json_encode(auth()->user()));
            $this->logger->error("data  ".json_encode($this->request->getPost()));
            return $this->failForbidden("No tienes permisos para crear transferencias");

        }
        $post  = (object)$this->request->getPost();

        if($post->dispatch === $post->receive )
        {
            return $this->fail("La tienda que recibe no puede ser la misma que envía ");
        }
        $inventoryId =$this->request->getPost("inventory");
        if(isset($inventoryId))
        {
            $inventory = model("App\\Models\\InventoryModel")->find($inventoryId);
            $decreased = $this->inventoryService->decrease($inventory,$post->qty);
        }else{
            $inventories = $this->inventoryService->getInventory($post->dispatch,"item",$post->item );
            $decreased = $this->inventoryService->decrease($inventories,$post->qty);
        }

        $transfers  = [];
        if($decreased) {

            $transferredInventory  = new \App\Entities\Inventory([
                "item" => $post->item,
                "supplier" => 0,
                "store" => $post->receive,
                "stock" => $post->qty,
                "bill" => "n/a",

            ]);
            try {
              $inserted =   $this->inventoryService->setInventory($transferredInventory, $this->request);
            } catch (\ReflectionException $e) {
                return $this->fail($e->getMessage());
            }
            if($inserted)
            {
                $errors = $this->inventoryService->getErrors();
                $transferred = $this->inventoryService->getInventory(
                    $transferredInventory->store,
                    "item",
                    $transferredInventory->item
                );
            }else{
                $transferred = [];
            }
        }

        if(!empty($transferred))
        {
            foreach( $this->inventoryService->getDecreasedId() as $decreasing)
            {
                if($decreasing->item==$post->item)
                {
                    $transfer = new \App\Entities\Transfer([
                        "inventory"=> $decreasing->id,
                        "item"=> $post->item ,
                        "qty"=> $post->qty,
                        "store_dispatch"=>$post->dispatch,
                        "store_receive"=>$post->receive,
                        "created_by"=>auth()->id()
                    ]);
                    $transfers[] =$transfer;
                }
                $this->inventoryService->resetDecreased();


            }
            try {
                $transfered = $this->transferModel->insertBatch($transfers);
            } catch (\ReflectionException $e) {
                return $this->fail($e->getMessage());
            }
        }else{
            $this->inventoryService->rollback();
            return $this->fail(["message"=>$this->inventoryService->getErrors()]);
        }



        return $decreased && $inserted && $transfered ? $this->respondCreated($transfers): $this->fail($this->transferModel->errors());

    }
}
