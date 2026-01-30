<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BankAccountModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class BankAccount extends BaseController
{
    use ResponseTrait;

    protected BankAccountModel $model;

    public function __construct()
    {
        $this->model = new BankAccountModel();
    }

    public function index(): ResponseInterface
    {
        $store = $this->request->getGet('store');
        if ($store) {
            return $this->respond($this->model->where('store', $store)->findAll());
        }
        return $this->respond($this->model->findAll());
    }

    public function show($id): ResponseInterface
    {
        $account = $this->model->find($id);
        return $account ? $this->respond($account) : $this->failNotFound('Bank account not found');
    }

    public function create(): ResponseInterface
    {
        $data = [
            'bank_name'      => $this->request->getPost('bank_name'),
            'alias'          => $this->request->getPost('alias'),
            'account_number' => $this->request->getPost('account_number'),
            'clabe'          => $this->request->getPost('clabe'),
            'owner_name'     => $this->request->getPost('owner_name'),
            'store'          => $this->request->getPost('store'),
            'currency'       => $this->request->getPost('currency') ?: 'MXN',
        ];

        try {
            if (!$this->model->insert($data, true)) {
                return $this->failValidationErrors($this->model->errors());
            }
        } catch (\Throwable $e) {
            return $this->fail($e->getMessage());
        }

        $id = $this->model->getInsertID();
        return $this->respondCreated($this->model->find($id));
    }

    public function update($id = null): ResponseInterface
    {
        if ($id === null) return $this->failValidationErrors('ID requerido');
        $data = $this->request->getRawInput();
        try {
            if (!$this->model->update($id, $data)) {
                return $this->failValidationErrors($this->model->errors());
            }
        } catch (\Throwable $e) {
            return $this->fail($e->getMessage());
        }
        return $this->respondUpdated($this->model->find($id));
    }

    public function delete($id = null): ResponseInterface
    {
        if ($id === null) return $this->failValidationErrors('ID requerido');
        $found = $this->model->find($id);
        if (!$found) return $this->failNotFound('Bank account not found');
        $this->model->delete($id);
        return $this->respondDeleted($found);
    }
}
