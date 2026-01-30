<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LineModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Line extends BaseController
{
    use ResponseTrait;

    protected LineModel $lineModel;

    public function __construct()
    {
        $this->lineModel = new LineModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respond($this->lineModel->findAll());
    }

    public function create(): ResponseInterface
    {
        $line = new \App\Entities\Lines($this->request->getPost());

        try {
            $inserted = $this->lineModel->save($line);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());

        }
        return $inserted
            ? $this->respondCreated($this->lineModel->find($this->lineModel->getInsertID()))
            : $this->fail($this->lineModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->lineModel->delete($id));
    }

    public function main(): string
    {
        $this->viewData['path'] = '/catalogo-linea';
        $this->viewData['title'] = 'Linea';
        return view('catalog/line', $this->viewData);
    }
}
