<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ColorModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Color extends BaseController
{
    use ResponseTrait;

    protected ColorModel $colorModel;

    public function __construct()
    {
        $this->colorModel = new ColorModel();
    }

    public function index()
    {
        return $this->respond($this->colorModel->findAll());
    }

    public function create(): ResponseInterface
    {
        $color = new \App\Entities\Color($this->request->getPost());

        try {
            $inserted = $this->colorModel->save($color);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());

        }
        return $inserted
            ? $this->respondCreated($this->colorModel->find($this->colorModel->getInsertID()))
            : $this->fail($this->colorModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->colorModel->delete($id));
    }

    public function main(): string
    {
        $this->viewData['path'] = '/catalogo-colores';
        $this->viewData['title'] = 'Colores';
        return view('catalog/color', $this->viewData);
    }
}
