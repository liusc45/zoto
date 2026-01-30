<?php

namespace App\Services;

use App\Entities\Patient;
use App\Entities\Prescription;
use App\Entities\PrescriptionDetail;
use App\Models\ConsultationModel;
use App\Models\PrescriptionDetailModel;
use App\Models\PrescriptionModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Entity\Entity;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Models\DatabaseException;
use ReflectionException;

class PrescriptionService
{
    
    private PrescriptionModel $prescriptionModel;
    private PrescriptionDetailModel $prescriptionDetailModel;
    private ConsultationModel $consultationModel;
    
    public function __construct()
    {
        $this->consultationModel = new ConsultationModel();
        $this->prescriptionModel = new PrescriptionModel();
        $this->prescriptionDetailModel = new PrescriptionDetailModel();
    }
    
    /**
     * @throws ReflectionException
     * @throws \CodeIgniter\Database\Exceptions\DatabaseException
     */
    public function setPrescription(RequestInterface $post): Prescription
    {
        $consultationId = $post->getPost("consultation");
        $consultation = $this->consultationModel->find($consultationId);

        $prescription = new Prescription([
            "patient"=>$post->getPost("patient"),
            "consultation"=>$consultation->id,
            "created_at"=>$consultation->created_at,
        ]);

        $this->prescriptionModel->save($prescription);
        $prescription->id = $this->prescriptionModel->getInsertID();
        $details = $post->getPost("prescription");
        $pDetails = $this->setDetail($details,$prescription);
        $prescription->details = $pDetails;
        
        return $prescription;
    }

    /**
     * @param Patient $patient
     * @param $last
     * @return array|object|null
     */
    public  function getPrescriptions(Patient $patient, $last=false): array|object|null
    {
        $prescriptions= model(PrescriptionModel::class)

            ->where(["patient"=>$patient->id])
            ->orderBy("created_at","DESC");
        $found = $last?$prescriptions->first():$prescriptions->findAll();
        if(is_null($found))
        {
            return null;
        }

        if(is_array($found)) {
            foreach ($found as $prescription) {
                $prescription->details = $this->getDetails($prescription);
                $range = (new RangeService)->calculateRange($prescription->details);
                $prescription->range = $range;
            }
        }else{
            $found->details = $this->getDetails($found);
            $range = (new RangeService)->calculateRange($found->details);
            $found->range = $range;
        }
        return $found;

    }


    /**
     * set a prescription from a request
     * @throws ReflectionException
     *
     */

    public function setLastPrescription(RequestInterface $request): Prescription
    {
        $lastDate = $request->getPost("created_at");
       // $prescription = $request->getPost("prescription");

        $prescription =    new Prescription([
            "consultation" =>null,
            "patient" => $request->getPost("patient"),
            "created_at" => Time::parse($lastDate)->addHours(11)->toDateTimeString(),
        ]);
        $prescription->id = $this->prescriptionModel->insert($prescription);
        $details = $request->getPost("prescription");
        $pDetails = $this->setDetail($details,$prescription);

        $prescription->details = $pDetails;

        return $prescription;
    }


    public function getDetails($prescription): array | PrescriptionDetail
    {
        if (!$prescription || !isset($prescription->id)) {
            return [];
        }

        $details = $this->prescriptionDetailModel
            ->where('prescription', $prescription->id)
            ->findAll();

        return $this->formatPrescription($details);
    }

    public function setDetail(array $details, Prescription $prescription): array
    {
        $pDetails = [];
        foreach ($details as $stage => $eyes) {
            foreach ($eyes as $eye => $value) {
                $detail  = new PrescriptionDetail([
                    'prescription' => $prescription->id,
                    'eye' => $eye,
                    'source' => $stage,
                    'sphere' => $value['sphere'],
                    'cylinder' => $value['cylinder'],
                    'axis' => $value['axis'],
                    'addition' => $value['addition']
                ]);
                //$prescription->details[] = $detail;
                $this->prescriptionDetailModel->insert($detail);
                $pDetails[] = $detail;
            }
        }
        return $pDetails;
    }

    

    public function getAllByPatient(int $patientId): array
    {
        $prescriptions = model(PrescriptionModel::class)
            ->select([
                "prescriptions.*",
                "consultations.attended_by as doctor",
                "consultations.sale",
                "consultations.comments as comments"
            ])
            ->join('consultations', 'consultations.id = prescriptions.consultation',"left")
            ->where('prescriptions.patient', $patientId)
            ->orderBy('prescriptions.created_at', 'DESC')
            ->findAll();

        foreach ($prescriptions as $prescription) {
            $prescription->prescription = $this->getDetails($prescription);
        }

        return $prescriptions;

    }
    private function formatPrescription(array $details): array|PrescriptionDetail
    {
        // Validaciones básicas: no tocar si no hay datos
        if (empty($details)) {
            return [];
        }

        $grouped = new PrescriptionDetail();
        $currentSource = [];

        foreach ($details as $detail) {

            $eye = $detail->eye ?? null;
            $source = $detail->source ?? null;
            if ($eye === null || $source === null) {
                continue;
            }

            if(!isset($currentSource[$source]))
            {
                $currentSource[$source] = new Entity();
            }
            $currentSource[$source]->{$eye}  = new Entity( [
                'id'       => $detail->id,
                'sphere'   => $detail->sphere,
                'cylinder' => $detail->cylinder,
                'axis'     => $detail->axis,
                'addition' => $detail->addition,
            ]);
        }
        $grouped->fill($currentSource);
        return $grouped;
    }

    public function getPrescriptionByConsultation($id): array
    {
        // Asumo que consultation es único o quieres la primera coincidencia
        $current = $this->prescriptionModel->where(["consultation" => $id])->first();
        $current->details = $this->getDetails($current);

        // Pasamos $current para buscar su referencia anterior
        $last = $this->getLastPrescription($current);

        return [
            "current" => $current,
            "last"    => $last
        ];
    }

    private function getLastPrescription($prescription): object|array|null
    {
        // Validación inicial
        if (!$prescription) {
            return null;
        }

        $last = $this->prescriptionModel
            ->where([
                // QUITO "consultation" => ... porque buscamos en el historial general
                "patient"      => $prescription->patient,
                "created_at <" => $prescription->created_at,
            ])
            // Opcional: Si quieres asegurarte de no traer la misma consulta por error de fecha
            // ->where('consultation !=', $prescription->consultation)
            ->orderBy("created_at", "DESC")
            ->first();

        // VALIDACIÓN DE SEGURIDAD: Solo buscamos detalles si encontramos una receta anterior
        if ($last) {
            $last->details = $this->getDetails($last);
        }

        return $last;
    }
}
