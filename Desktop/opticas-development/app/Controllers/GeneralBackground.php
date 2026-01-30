<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConsultationModel;
use App\Models\GeneralBackgroundModel;
use App\Services\ConsultationService;
use App\Services\PatientService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class GeneralBackground extends BaseController
{
    use ResponseTrait;
    
    protected GeneralBackgroundModel $generalBackgroundModel;
    
    public function __construct()
    {
        $this->generalBackgroundModel = new GeneralBackgroundModel();
    }
    
    public function index()
    {
        //
    }
    
    public function create(): ResponseInterface
    {
        $diabetes = $this->request->getPost("diabetes");
        $hypertensive = $this->request->getPost("hypertensive");

        $generalBackground = new \App\Entities\GeneralBackground([
            "healthy" => $this->request->getPost("healthy")??true,
            "diabetes" => $diabetes,
            "last_glucose_date" => $this->request->getPost("last_glucose_date"),
            "glucose_date_number" =>$diabetes ? $this->request->getPost("glucose_date_number") : null,
            "glucose_date_unit" => $diabetes ? $this->request->getPost("glucose_date_unit") : null,
            "glucose_level" => $diabetes ?$this->request->getPost("glucose_level") : null,
            "hypertensive" =>$hypertensive,
            "last_blood_pressure_date" => $this->request->getPost("last_blood_pressure_date"),
            "blood_date_number" =>$hypertensive? $this->request->getPost("blood_date_number") : null,
            "blood_date_unit" => $hypertensive? $this->request->getPost("blood_date_unit") : null,
            "blood_pressure_level" => $hypertensive? $this->request->getPost("blood_pressure_level") : null,
            "comments" => $this->request->getPost("comments"),
            "observations" => $this->request->getPost("observations"),
        ]);

        try {

            $consultation = (new ConsultationService)->getConsultation($this->request);
            $generalBackground->consultation = $consultation->id;
           $actualBackground =  $this->generalBackgroundModel
                ->where(["consultation"=>$generalBackground->consultation])
                ->first();
            if(!is_null($actualBackground)){
                $generalBackground->id = $actualBackground->id;
            }

        $saved= $this->generalBackgroundModel->save($generalBackground);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $saved ?
            $this->respondCreated($generalBackground):
            $this->fail($this->generalBackgroundModel->errors());
    }
    public function update($id): ResponseInterface
    {
        $generalBackground = $this->generalBackgroundModel->where(["consultation"=>$id])->first();
        if(is_null($generalBackground))
        {
            $consultation = model(ConsultationModel::class)->find($id);
            $patient = (new PatientService)->getPatient($consultation->patient);

        }
        $generalBackground->fill($this->request->getRawInput());
        try {
            $updated = $this->generalBackgroundModel->save($generalBackground);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ?
            $this->respondUpdated($generalBackground):
            $this->fail($this->generalBackgroundModel->errors());
    }
}
