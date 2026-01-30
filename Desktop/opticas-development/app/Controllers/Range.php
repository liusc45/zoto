<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RangeModel;
use App\Models\RangeIntervalModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Range extends BaseController
{
    use ResponseTrait;

    protected RangeModel $rangeModel;
    protected RangeIntervalModel $intervalModel;

    public function __construct()
    {
        $this->rangeModel = new RangeModel();
        $this->intervalModel = new RangeIntervalModel();
    }

    // API: list ranges
    public function index()
    {
        return $this->respond($this->rangeModel->findAll());
    }

    // API: create range
    public function create(): ResponseInterface
    {
        $data = $this->request->getPost();
        $result = $this->rangeModel->insert($data);
        if ($result === false) {
            return $this->failValidationErrors($this->rangeModel->errors());
        }
        $id = $this->rangeModel->getInsertID();
        return $this->respondCreated($this->rangeModel->find($id));
    }

    // API: update range
    public function update($id = null): ResponseInterface
    {
        $data = $this->request->getRawInput();
        if (!$this->rangeModel->update($id, $data)) {
            return $this->failValidationErrors($this->rangeModel->errors());
        }
        return $this->respond($this->rangeModel->find($id));
    }

    // API: delete range
    public function delete($id = null): ResponseInterface
    {
        $deleted = $this->rangeModel->delete($id);
        return $this->respondDeleted($deleted);
    }

    // View page
    public function main(): string
    {
        $this->viewData['path'] = '/catalogo-rangos';
        $this->viewData['title'] = 'Rangos de Graduación';
        return view('catalog/range', $this->viewData);
    }

    // API: list intervals for a range
    public function show($rangeId)
    {
        $intervals = $this->intervalModel->where('range', $rangeId)->findAll();
        return $this->respond($intervals);
    }

    // API: create interval for a range
    public function createInterval($rangeId)
    {
        $data = $this->request->getPost();
        $data['range'] = (int)$rangeId;
        try {
            $inserted = $this->intervalModel->insert($data);
        } catch (\Throwable $e) {
            return $this->failValidationErrors($e->getMessage());
        }
        if ($inserted === false) {
            return $this->failValidationErrors($this->intervalModel->errors());
        }
        $id = $this->intervalModel->getInsertID();
        return $this->respondCreated($this->intervalModel->find($id));
    }

    // API: delete interval
    public function deleteInterval($id)
    {
        $deleted = $this->intervalModel->delete($id);
        return $this->respondDeleted($deleted);
    }
}
