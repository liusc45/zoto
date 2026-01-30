<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConsultationContactModel;
use App\Models\ConsultationModel;
use App\Services\ConsultationService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class ConsultationContact extends BaseController
{
    use ResponseTrait;
    protected ConsultationContactModel $consultationContactModel;
    public function __construct()
    {
        $this->consultationContactModel = new ConsultationContactModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respond($this->consultationContactModel->findAll());

    }
    public function create(): ResponseInterface
    {
        $contact = new \App\Entities\ConsultationContact($this->request->getPost());
        if(!ConsultationService::exist($this->request->getPost('consultation'))) {
            $consultation = (new ConsultationService)->setConsultation($this->request);
            $contact->consultation = $consultation->id;
        }

        try {
           $save =  $this->consultationContactModel->save($contact);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $save ?
            $this->respondCreated($this->consultationContactModel->find($this->consultationContactModel->getInsertID())):
            $this->fail($this->consultationContactModel->errors());
    }
    public function update($id): ResponseInterface
    {
        $consultationContact = $this->consultationContactModel->where(["consultation"=>$id])->first();
        if(is_null($consultationContact))
        {
            $consultation = model(ConsultationModel::class)->find($id);
            
        }
        $consultationContact->fill($this->request->getRawInput());
        try {
            $updated = $this->consultationContactModel->save($consultationContact);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ? $this->respondUpdated($consultationContact):$this->fail($this->consultationContactModel->errors());
    }
}
