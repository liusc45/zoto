<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BrandModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Brand extends BaseController
{
    use ResponseTrait;

    protected BrandModel $brandModel;

    public function __construct()
    {
        $this->brandModel = new BrandModel();
    }

    public function index()
    {
        return $this->respond($this->brandModel->findAll());
    }

    public function create(): ResponseInterface
    {
        $brand = new \App\Entities\Brand($this->request->getPost());

        try {
            $inserted = $this->brandModel->save($brand);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());

        }
        return $inserted
            ? $this->respondCreated($this->brandModel->find($this->brandModel->getInsertID()))
            : $this->fail($this->brandModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->brandModel->delete($id));
    }

    public function main(): string
    {
        $this->viewData['path'] = '/catalogo-marcas';
        $this->viewData['title'] = 'Marcas';
        return view('catalog/brand', $this->viewData);
    }
}
