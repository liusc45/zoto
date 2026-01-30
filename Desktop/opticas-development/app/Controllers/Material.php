<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Material extends BaseController
{
    use ResponseTrait;

    protected MaterialModel $materialModel;

    public function __construct()
    {
        $this->materialModel = new materialModel();
    }

    public function index()
    {
        return $this->respond($this->materialModel->findAll());
    }

    public function create(): ResponseInterface
    {
        $material = new \App\Entities\Material($this->request->getPost());

        try {
            $inserted = $this->materialModel->save($material);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());

        }
        return $inserted
            ? $this->respondCreated($this->materialModel->find($this->materialModel->getInsertID()))
            : $this->fail($this->materialModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->materialModel->delete($id));
    }

    public function main(): string
    {
        $this->viewData['path'] = '/catalogo-materiales';
        $this->viewData['title'] = 'Materiales';
        return view('catalog/material', $this->viewData);
    }
}
