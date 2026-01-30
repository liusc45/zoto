<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\ItemModel;
use App\Services\InventoryService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Item extends BaseController
{
    use ResponseTrait;
    protected ItemModel $itemModel;

    protected $cache;
    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->cache = \Config\Services::cache();
    }

    public function index(): ResponseInterface
    {
        if($this->cache->get('items')===null)
        {
            $store = session("store")->id;
            $items =  $this->itemModel
                ->select([
                    "items.id",
                    "key",
                    "items.name",
                    "barcode",
                    "coalesce(lines.name, '') line",
                    "coalesce(brands.name, '') brand",
                    "items.model",
                    "items.color_key",
                    //"coalesce(frames.size, '0') size",
                    "items.size size",
                    "item_prices.amount as price",
                    "inventories.stock",

                ])
                ->join("inventories","inventories.item = items.id AND inventories.store = $store ","left")
                ->join("item_prices","item_prices.item = items.id AND item_prices.type = 'regular'","left")
                ->join("frames","frames.item = items.id","left")
                ->join("lines","lines.id = items.line","left")
                ->join("brands","brands.id = items.brand","left")
                ->join("colors","colors.id = items.color","left")
                ->findAll();
            $this->cache->save('items',$items);
        }else{
            $items = $this->cache->get('items');
        }

        return $this->respond($items);

    }
    public function showFiltered(): ResponseInterface
    {
        $filters = $this->request->getGet();


        $this->itemModel
                ->select([

                    "items.id",
                    "key",
                    "barcode",
                    "items.name",
                    "coalesce(lines.name, 'Sin Linea') line",
                    "coalesce(brands.name, 'Sin Marca') brand",
                    "items.model",
                    "items.color_key",
                    "coalesce(colors.name, 'Sin Color') color",
                    "items.size size",
                    "item_prices.amount as price",
                    "inventories.stock",
                    "item_prices.shipping_cost"
                ])
            ->join("inventories","inventories.item = items.id AND inventories.store = $store ","left")
            ->join("lines","lines.id = items.line","left")
            ->join("brands","brands.id = items.brand","left")
            ->join("colors","colors.id = items.color","left")
            ->join("item_prices","item_prices.item = items.id","left");

        foreach ($filters as $key => $value  )
        {
            $this->itemModel->where("items.$key",$value);
        }

        $items=$this->itemModel->findAll();
        return $this->respond($items);

    }
    public function show($id): ResponseInterface
    {
        return $this->respond($this->itemModel->find($id));


    }

    public function create(): ResponseInterface
    {
        $item = new \App\Entities\Item($this->request->getPost());
        $item->name = addslashes($item->name);
      
        try {
            $itemId = $this->itemModel->insert($item);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }

        if (!is_numeric($itemId))
        {
            $return = $this->fail($this->itemModel->errors());
        }else{
            $return = $this->respondCreated($this->itemModel->find($itemId));
        }

        return $return;

    }

    public function update($id): ResponseInterface
    {
        $item = $this->itemModel
            ->find($id)
            ->fill($this->request->getRawInput());

        try {
           
            $updated = $this->itemModel->save($item);
        } catch (\ReflectionException $e) {
            return $this->fail( $e->getMessage());
        }

        return $updated?$this->respond($item):$this->fail($this->itemModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        $item = $this->itemModel->find($id);
        $inventory = new InventoryService(model(InventoryModel::class));
        $items = $inventory->getInventory(0,"item",$id);
        $deleted =  $this->itemModel->delete($id);
        if(!empty($items))
        {
            $deleted = $deleted && $inventory->deleteInventory($items);
            
        }
        return $this->respondDeleted(["item" => $item, "intentory"=>$items, "deleted" => $deleted]);
    }
    
    public function stock()
    {
        return $this->respond( $this->itemModel
            ->join("inventories","inventories.item = items.id","left")
            ->join("stores","inventories.store = stores.id","left")
            ->select("items.id, items.name, inventories.code, stock, coalesce(stores.name,'sin tienda') store ")
            ->selectSum("inventories.stock", "stock")
            ->groupBy("items.id,store")
            //->builder()->getCompiledSelect());
           ->findAll());
    }
}
