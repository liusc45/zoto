<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConsultationModel;
use App\Models\VisualBackgroundModel;
use App\Services\ConsultationService;
use App\Services\PatientService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class VisualBackground extends BaseController
{
    use ResponseTrait;
    protected VisualBackgroundModel $visualBackgroundModel;
    public function __construct()
    {
        $this->visualBackgroundModel = new VisualBackgroundModel();
    }
    
    public function index()
    {
        //
    }
    public function create(): ResponseInterface
    {
        $visualBackground = new \App\Entities\VisualBackground([

            "glasses" => $this->request->getPost("glasses")??false,
            "last_check_date" => $this->request->getPost("last_check_date"),
            "fatigue" => $this->request->getPost("fatigue"),
            "burning" => $this->request->getPost("burning"),
            "itching" => $this->request->getPost("itching"),
            "photophobia" => $this->request->getPost("photophobia"),
            "redness" => $this->request->getPost("redness"),
            "blurry" => $this->request->getPost("blurry"),
            "headache" => $this->request->getPost("headache"),
            "secretion" => $this->request->getPost("secretion"),
            "other_conditions" => $this->request->getPost("other_conditions"),
            "comments" => $this->request->getPost("comments"),
        ]);
        try {

            $consultation = (new ConsultationService)->getConsultation($this->request);
            $visualBackground->consultation = $consultation->id;

            $actualBackground =  $this->visualBackgroundModel
                ->where(["consultation"=>$visualBackground->consultation])
                ->first();
            if(!is_null($actualBackground)){
                $visualBackground->id = $actualBackground->id;
            }

            $saved= $this->visualBackgroundModel->save($visualBackground);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $saved ?
            $this->respondCreated($visualBackground):
            $this->fail($this->visualBackgroundModel->errors());
    }
    public function show($id)
    {
        //
    }
    public function update($id): ResponseInterface
    {
        $visualBackground = $this->visualBackgroundModel->where(["consultation"=>$id])->first();
        if(is_null($visualBackground))
        {
            return $this->failNotFound('Consulta no encontrada');
        }
        $visualBackground->fill($this->request->getRawInput());
        try {
            $updated = $this->visualBackgroundModel->save($visualBackground);
        }catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ?
            $this->respondUpdated($visualBackground):
            $this->fail($this->visualBackgroundModel->errors());
    }
}
