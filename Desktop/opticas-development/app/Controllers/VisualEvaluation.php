<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConsultationModel;
use App\Models\VisualEvaluationModel;
use App\Services\ConsultationService;
use App\Services\PatientService;
use App\Services\PrescriptionService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class VisualEvaluation extends BaseController
{
    use ResponseTrait;
    protected VisualEvaluationModel $visualEvaluationModel;
    public function __construct()
    {
        $this->visualEvaluationModel = new VisualEvaluationModel();
    }
    
    public function index()
    {
        //
    }
    public function show($id): ResponseInterface
    {
        return $this->respond($this->visualEvaluationModel->find($id));
    }
    
    public function create(): ResponseInterface
    {
        $visualEvaluation = new \App\Entities\VisualEvaluation($this->request->getPost());

        try {
            $consultation = (new ConsultationService)->getConsultation($this->request);
            $visualEvaluation->consultation = $consultation->id;


            $visualEvaluation->anomalies_image = $this->anomaliesImage();

            $actualEvaluation =  $this->visualEvaluationModel
                ->where(["consultation"=>$visualEvaluation->consultation])
                ->first();

            if(!is_null($actualEvaluation)){
                $visualEvaluation->id = $actualEvaluation->id;
            }

            $saved= $this->visualEvaluationModel->save($visualEvaluation);
        }catch (\ReflectionException | DatabaseException $e) {
            return $this->fail($e->getMessage());
        }

        return $saved ?
            $this->respondCreated($this->visualEvaluationModel->find($this->visualEvaluationModel->getInsertID())):
            $this->fail($this->visualEvaluationModel->errors());
    }


    public function update($id): ResponseInterface
    {
        $visualEvaluation = $this->visualEvaluationModel->where(["consultation"=>$id])->first();

        if(is_null($visualEvaluation)){
            $visualEvaluation = new \App\Entities\VisualEvaluation([
                "consultation"=>$id,
                "anomalies_image"=>null
            ]);

        }
        $updateData = $this->request->getRawInput();
        $visualEvaluation->fill($updateData);

        $isAnomaliesImage = array_key_exists("anomalies_image",$updateData);

        $isAnomaliesImage && $visualEvaluation->anomalies_image = $this->anomaliesImage($updateData["anomalies_image"]);
        try {
            $updated = $this->visualEvaluationModel->save($visualEvaluation);
            if($isAnomaliesImage){
                $visualEvaluation->anomalies_image = $updateData["anomalies_image"];
            }
        } catch (\ReflectionException | DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ?
            $this->respondUpdated($visualEvaluation):
            $this->fail($this->visualEvaluationModel->errors());
    }
    private function anomaliesImage(?string $based64Image = null ): false|string
    {
        
        // Obtener los datos del canvas
        $canvasData = $based64Image??$this->request->getPost('anomalies_image');
        
        // Remover el encabezado de datos base64
        $imageData = str_replace('data:image/png;base64,', '', $canvasData);
//        $imageData = str_replace(' ', '+', $imageData);
        
        // Decodificar la imagen
        $imageBinary = base64_decode($imageData);
        return $imageBinary;
        
        // Crear un nombre único para la imagen
//        $imageName = uniqid() . '.png';
//
//        // Guardar la imagen en el sistema de archivos
//        file_put_contents(WRITEPATH . 'uploads/visual_evaluations/' . $imageName, $imageBinary);
//
    }

}
