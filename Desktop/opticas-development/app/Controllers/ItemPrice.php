<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\ItemPriceModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ItemPrice extends BaseController
{
    use ResponseTrait;

    protected ItemPriceModel $priceModel;
    protected ItemModel $itemModel;
    private CacheInterface $cache;

    public function __construct()
    {
        $this->cache = \Config\Services::cache();
        $this->priceModel = new ItemPriceModel();
        $this->itemModel = new ItemModel();
    }

    public function main()
    {
        return view('components/itemprice/main',  ['title' => 'Gestor de Precios']);
    }


    public function index(): ResponseInterface
    {
        if($this->cache->get('item_prices')===null)
        {
            $prices = $this->priceModel->select([
                "item",
                "items.key as item_key",
                "items.name as item_name",
                "concat('[',group_concat(json_object('type',type,'amount',amount,'starts_at',date(starts_at))),']') as prices",
            ])
                ->whereNotIn("type",["regular"])
                ->join("items","items.id = item_prices.item")
                ->groupBy("item")
                ->findAll();
            $this->cache->save('item_prices',$prices);
        }
        else{
            $prices = $this->cache->get('item_prices');
        }
        return $this->respond($prices);



        return $this->respond($prices);
    }

    public function show($id): ResponseInterface
    {
        $price = $this->priceModel
            ->select('item_prices.*, items.name as item_name')
            ->join('items', 'items.id = item_prices.item')
            ->find($id);

        if (!$price) {
            return $this->failNotFound('Precio no encontrado');
        }

        return $this->respond($price);
    }

    public function create(): ResponseInterface
    {
        $price = new \App\Entities\ItemPrice($this->request->getJSON(true));

        try {
            $priceId = $this->priceModel->insert($price);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }

        if (!is_numeric($priceId)) {
            return $this->fail($this->priceModel->errors());
        }

        return $this->respondCreated($this->priceModel->find($priceId));
    }

    public function update($id): ResponseInterface
    {
        if (!$this->priceModel->find($id)) {
            return $this->failNotFound('Precio no encontrado');
        }

        $price = new \App\Entities\ItemPrice($this->request->getJSON(true));
        $price->id = $id;

        try {
            $updated = $this->priceModel->save($price);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }

        if (!$updated) {
            return $this->fail($this->priceModel->errors());
        }

        return $this->respond($this->priceModel->find($id));
    }

    public function delete($id): ResponseInterface
    {
        if (!$this->priceModel->find($id)) {
            return $this->failNotFound('Precio no encontrado');
        }

        if ($this->priceModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }

        return $this->failServerError('Error al eliminar el precio');
    }

    public function getActivePrices($itemId = null): ResponseInterface
    {
        $builder = $this->priceModel
            ->select(['item_prices.*',
                'items.name as item_name',
                'items.key as item_key'])
            ->join('items', 'items.id = item_prices.item')
            ->where('starts_at <=', date('Y-m-d H:i:s'))
            ->where('(ends_at >= ? OR ends_at IS NULL)', [date('Y-m-d H:i:s')]);

        if ($itemId) {
            $builder->where('item', $itemId);
        }

        return $this->respond($builder->findAll());
    }
}