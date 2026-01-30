<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\Contacts;
use App\Models\CompanyModel;
use App\Models\ConsultationContactModel;
use App\Models\ConsultationModel;
use App\Models\ContactModel;
use App\Models\DoctorModel;
use App\Models\GeneralBackgroundModel;
use App\Models\ItemModel;
use App\Models\OccupationModel;
use App\Models\PatientModel;
use App\Models\PersonModel;
use App\Models\VisualBackgroundModel;
use App\Models\VisualEvaluationModel;
use App\Services\ConsultationService;
use App\Services\PatientService;
use App\Services\PrescriptionService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Config\Database;
use stdClass;

class Consultation extends BaseController
{
    use ResponseTrait;
    protected ConsultationModel $consultationModel;
    public function __construct()
    {
        $this->consultationModel = new ConsultationModel();

    }

    public function index()
    {
        $consultations = $this->consultationModel->findAll();
        return $this->respond($consultations);
    }

    /**
     * @route /nueva-consulta/{patient}
     * @param $patientId
     * @return string|RedirectResponse
     *
     * */
    public function new($id): string|RedirectResponse
    {
        $patientService = new PatientService();
        $errors='';
        if($id === '0') {
            $person = $this->request->getGet("person");
            try {
                $patient = $patientService->setPatient($person);
                return redirect()->to("/nueva-consulta/".$patient->id);
            } catch (\ReflectionException $e) {
                $errors  = $e->getMessage();
            }
        }
        $data['contacts'] = model(ItemModel::class)
            ->select(["distinct(name)","id"])
            ->where("line",3)
            ->findAll();

        $patient = model(PatientModel::class)
            ->select([
                "patients.id",
                "patients.person",
                "patients.original_id",
                "persons.name",
                "persons.last_name",
                "persons.dob",
            ])
            ->join("persons","persons.id = patients.person")
            ->find($id==='0'?$patient->id:$id);
        session()->set("consultation");
        $data['consultation'] = new \App\Entities\Consultation([
            "id" => null,
            "patient" => $id==='0'?$patient->id:$id,
        ]);

        $data['patient'] = $patient;
        $data['doctors'] = model(DoctorModel::class)
            ->select(["doctors.id","persons.name","persons.last_name"])
            ->join("persons","persons.id = doctors.person")->findAll();
        $data["lastPrescription"] = (new PrescriptionService)->getPrescriptions($patient,true);
        $data['errors'] = $errors;
        $data['path'] = "Nueva Consulta";
        $data['edit'] = false;
        return view('components/consultation/main', $data);
    }


    public function show($id): ResponseInterface
    {
        $consultation =(new ConsultationService)->getConsultationById($id);

        return $this->respond($consultation);
    }

    public function edit($id): RedirectResponse|string
    {
        $consultation =(new ConsultationService)->getConsultationById($id);
        if(is_null($consultation))
        {
            return redirect()->back("404");
        }

        $patient = (new PatientService)->getPatient($consultation->patient);
        $prescriptions = (new PrescriptionService)->getPrescriptionByConsultation($consultation->id);

        $contacts = model(ItemModel::class)
            ->select(["distinct(name)","id"])
            ->where("line",3)
            ->findAll();

        $doctor= model(DoctorModel::class)
            ->select(["doctors.id","concat_ws(' ', persons.name, persons.last_name) as name"])
            ->join("persons","persons.id = doctors.person")
            ->find($consultation->doctor);
        return view('components/consultation/main',[
            "consultation"=>$consultation,
            "prescriptions"=>$prescriptions,
            "patient"=>$patient,
            "doctor"=>$doctor,
            "contacts"=>$contacts,
            "path" => "Editar Consulta",
            "edit"=>true,
        ]);

    }


    public function update($id): ResponseInterface
    {
        $consultation = $this->consultationModel->find($id);
        $consultation->fill($this->request->getRawInput());
        try {
            $updated = $this->consultationModel->save($consultation);
            return $this->respondUpdated($consultation);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ?
            $this->respondUpdated($consultation):
            $this->fail($this->consultationModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        $consultation = $this->consultationModel->find($id);
        $deleted = $this->consultationModel->delete($id);
        return $deleted ? $this->respondDeleted($consultation) : $this->fail($this->consultationModel->errors());
    }

    public function lastConsultation(): ResponseInterface
    {

        $consultation = $this->consultationModel
            ->select(["id","patient","created_at as ago"])
            ->where("sale",null)
            ->where("date(created_at)",Time::today()->toDateString())
            ->groupBy("patient")
            ->findAll();

        return $this->respond($consultation);
    }

}
