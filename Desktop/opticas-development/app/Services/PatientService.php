<?php

namespace App\Services;

use App\Entities\Patient;
use App\Models\PatientModel;
use App\Models\PersonModel;
use CodeIgniter\Config\BaseService;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use ReflectionException;

class PatientService extends BaseService
{
    protected PatientModel $patientModel;
    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }

    /**
     * @param $id
     * @return Patient|array|null
     */
    public function getPatient($id): Patient|array|null
    {
        return $this->patientModel
            ->select([
                'patients.*',
                'persons.name',
                'persons.last_name',
                'persons.dob',
                'persons.email',
                'persons.street',
                'persons.city',
                'persons.state',
                'persons.postal_code',
                "persons.main_phone",
                'persons.id as phones',
            ])
            ->join('persons', 'persons.id = patients.person')
            ->find($id);
    }
    
    /**
     * @throws ReflectionException
     */
    public function setPatient($person): object|array|null
    {
        $patient = new Patient([
            "person" => $person,
        ]);
        $this->patientModel->save($patient);
        return $this->patientModel->find($this->patientModel->getInsertID());
    }
    
    public function setCard($person, $card): ?Patient
    {
        $patient = $this->patientModel->where("person", $person)->first();
        if(is_null($patient)){
            return null;
        }
        $patient->card_id = $card;
        $this->patientModel->save($patient);
        return $patient;
    }

}
