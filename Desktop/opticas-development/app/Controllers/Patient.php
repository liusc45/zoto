<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Person;
use App\Models\PatientModel;
use App\Models\PersonModel;
use App\Services\PersonService;
use App\Services\UserService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Patient extends BaseController
{
    use ResponseTrait;
    protected PersonModel $personModel;
    protected PatientModel $patientModel;

    public function __construct()
    {
        $this->personModel = new PersonModel();
        $this->patientModel = new PatientModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respond( $this->patientModel
            ->select([
                "patients.id",
                "patients.original_id",
                "patients.card_id",
                "persons.id as person",
                "patients.user",
                "patients.company",
                "persons.name",
                "persons.last_name",
                "persons.dob",
                "persons.main_phone",
                "persons.email",
                "persons.street",
                "persons.city",
                "persons.state",
                "persons.postal_code",
            ])
            ->join("persons","persons.id = patients.person")
            ->where(["patients.store"=>session("store")->id])
           // ->groupBy("patients.id")
            ->findAll());
    }

    public function show($id): ResponseInterface
    {
        return $this->respond($this->patientModel
            ->select([
                "patients.id",
                "patients.person",
                "patients.user",
                "patients.company",
                "patients.original_id",
                "persons.name",
                "persons.last_name",
                "persons.dob",
                "persons.email",
                "persons.occupation",
                "persons.street",
                "persons.city",
                "persons.state",
                "persons.postal_code",
            ])
            ->join("persons","persons.id = patients.person","left")
            ->find($id));
    }

    public function create(): ResponseInterface
    {
        $user = null;
        try {
            $person = (new PersonService)->setPerson($this->request);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        $patient = new \App\Entities\Patient([
            "person"=>$person->id,
            "store"=> session("store")->id,
            "card_id" => $this->request->getPost("card_id"),
            "company" => $this->request->getPost("company"),
        ]);
        try {
            $saved = $this->patientModel->save($patient);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $saved ?
            $this->respondCreated($this->patientModel->find($this->patientModel->getInsertID())):
            $this->fail($this->patientModel->errors());

    }

    public function delete(int $id): ResponseInterface
    {
        $patient = $this->patientModel->withDeleted()->find($id);
        $this->patientModel->delete($patient->id);
        return $this->respondDeleted($patient);
    }
}
