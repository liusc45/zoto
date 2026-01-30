<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\PrescriptionDetailModel;
use App\Models\PrescriptionModel;
use App\Services\PatientService;
use App\Services\PrescriptionService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;

class Prescription extends BaseController
{
    use ResponseTrait;
    protected PrescriptionDetailModel $prescriptionModel;
    private PrescriptionService $prescriptionService;
    
    public function __construct()
    {
        $this->prescriptionModel = new PrescriptionDetailModel();
        $this->prescriptionService = new PrescriptionService();
    }
    
    public function index(): ResponseInterface
    {
        return $this->respond($this->prescriptionModel->findAll());
    }
    
    public function create(): ResponseInterface
    {
        $lastPrescription = $this->request->getPost('last_prescription');
        try {
            if(!is_null($lastPrescription))
            {
                $prescription = $this->prescriptionService->setLastPrescription($this->request);
            }else{

                $prescription  = $this->prescriptionService->setPrescription($this->request);
            }


        } catch (\ReflectionException| DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
        return
            $this->respondCreated($prescription);
        //$this->fail($this->prescriptionModel->errors());
        
    }
    public function update($detail): ResponseInterface
    {
        $prescription = $this->prescriptionModel->find($detail);

        try {

            $prescription->fill($this->request->getRawInput());
        
            $updated = $this->prescriptionModel->save($prescription);
        
        } catch (\ReflectionException | DatabaseException |  DataException $e) {
            return $this->fail([
                $e->getMessage()
            ]);
        }
        return $updated ?
            $this->respondUpdated($prescription):
            $this->fail($this->prescriptionModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        $prescriptionModel = new PrescriptionModel();
        $prescription =$prescriptionModel->find($id);
        $deleted =  $prescriptionModel->delete($id);
        return $deleted ? $this->respondDeleted($prescription):$this->fail($this->prescriptionModel->errors());
    }




    public function prescriptionByPatient($patientNumber): ResponseInterface
    {
        $last = $this->request->getGet('type');
        $patient = (new PatientService)->getPatient($patientNumber);
        $prescription = (new PrescriptionService)->getPrescriptions($patient,$last??false);

        return $this->respond($prescription?? new \App\Entities\Prescription());
    }
}
