<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OccupationModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Occupation extends BaseController
{
    use ResponseTrait;

    protected OccupationModel $occupationModel;

    public function __construct()
    {
        $this->occupationModel = new OccupationModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respond($this->occupationModel->findAll());
    }

    public function create(): ResponseInterface
    {
        $occupation = new \App\Entities\Occupation($this->request->getPost());

        try {
            $inserted = $this->occupationModel->save($occupation);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());

        }
        return $inserted
            ? $this->respondCreated($this->occupationModel->find($this->occupationModel->getInsertID()))
            : $this->fail($this->occupationModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->occupationModel->delete($id));
    }
}
