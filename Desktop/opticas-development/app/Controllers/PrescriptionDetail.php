<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PrescriptionDetailModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class PrescriptionDetail extends BaseController
{
    use ResponseTrait;
    protected PrescriptionDetailModel $prescriptionDetailModel;

    public function __construct()
    {
        $this->prescriptionDetailModel = new PrescriptionDetailModel();
    }

    public function index()
    {
        //
    }
    public function update($id): ResponseInterface
    {
        $detail = $this->prescriptionDetailModel->find($id);
        if(is_null($detail)){
            return $this->fail('Prescription detail not found')->setStatusCode(404);
        }
        $detail->fill($this->request->getRawInput());

        try {
            $updated = $this->prescriptionDetailModel->save($detail);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated?
            $this->respondUpdated($detail):
            $this->fail($this->prescriptionDetailModel->errors());

    }
}
