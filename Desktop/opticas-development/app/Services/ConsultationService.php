<?php

namespace App\Services;

use App\Entities\Consultation;
use App\Entities\Patient;
use App\Entities\Sale;
use App\Models\ConsultationModel;
use App\Models\DoctorModel;
use App\Models\GeneralBackgroundModel;
use App\Models\VisualBackgroundModel;
use App\Models\VisualEvaluationModel;
use CodeIgniter\Database\Config;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;
use Config\Database;
use Config\Services;
use ReflectionException;

class ConsultationService
{
    protected ConsultationModel $consultationModel;
    public function __construct(?ConsultationModel $consultationModel = null  )
    {
        $this->consultationModel = $consultationModel?? new ConsultationModel();
    }

    public  function getConsultation(RequestInterface $request): array|object
    {
        return session()->get("consultation")?? $this->setConsultation($request);
    }

    /**
     * @throws ReflectionException
     *
     */
    public function setConsultation(RequestInterface $request): array|object|null
    {
        $doctor = model(DoctorModel::class)->find($request->getPost("attended_by"));


        $consultation  = new Consultation([
            "patient" => $request->getPost("patient"),
            "attended_by" => $doctor?->id,
            "created_at" => $request->getPost("created_at"),
        ]);
        $saved = $this->consultationModel->save($consultation);
        $consultation = $this->consultationModel->find($this->consultationModel->getInsertID());
        session()->set("consultation",$consultation);
        return $saved ?
           $consultation :
            $this->consultationModel->errors();


    }

    public function getConsultationByPatient(Patient $patient): array|object|null
    {
        $consultations =  $this->consultationModel
            ->select([
                "consultations.id id ",
                "consultations.patient ",
                "consultations.sale",
                "attended_by as doctor",
                "consultations.created_at",
                "consultations.created_at as ago",

                "consultation_date",
            ])
            ->join('prescriptions','prescriptions.consultation = consultations.id','left')

            ->where(['consultations.patient'=>$patient->id])
           // ->orderBy("consultations.created_at","DESC")
            ->orderBy("prescriptions.created_at","DESC")
            ->findAll();

        return $consultations;
    }

    public function getConsultationById(int $id): array|object|null
    {
        $consultation = $this->consultationModel->find($id)??new \App\Entities\Consultation();
        $where = ["consultation"=>$id];
        $consultation->general_background = model(GeneralBackgroundModel::class)->where($where)->first()??new \App\Entities\GeneralBackground();
        $consultation->visual_background = model(VisualBackgroundModel::class)->where($where)->first()?? new \App\Entities\VisualBackground();
        $consultation->visual_evaluation = model(VisualEvaluationModel::class)->where($where)->first() ?? new \App\Entities\VisualEvaluation();
        // Load contact lenses editable data for rendering in the view
        $consultation->contact_lenses = model(\App\Models\ConsultationContactModel::class)
            ->where($where)
            ->first() ?? new \App\Entities\ConsultationContact();
        return $consultation;
    }

    /**
     * @throws ReflectionException
     */
    public function consultationSale(Sale $sale, array $consultations): bool
    {
        $updates=[];
        foreach ($consultations as $consultation)
        {
            if(!is_numeric($consultation)) continue;
            $consultationToUpdate = $this->consultationModel->find($consultation);
            $consultationToUpdate->sale = $sale->id;
            $updates[] = $consultationToUpdate;
        }
        $updated = !empty($updates)&& !is_bool( $this->consultationModel->updateBatch($updates,"id"));
        return !$updated;
    }

    public function getNextId(): int
    {
        $tableName = 'consultations'; // Replace with your actual table name
        $databaseName = $this->consultationModel->db->database; // Gets the current database name

        $consultation = $this->consultationModel
            ->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?",[$databaseName, $tableName])
            ->getRow();
        return $consultation->AUTO_INCREMENT;
    }

}
