<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PersonModel;
use App\Services\PatientService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;

class Person extends BaseController
{
    use ResponseTrait;
    protected PersonModel $personModel;


    public function __construct()
    {
        $this->personModel = new PersonModel();
    }

    public function update($id): ResponseInterface
    {
        $person = $this->personModel->find($id);
        if(is_null($person)){
            return $this->failNotFound('Paciente no existe');

        }
        $propToUpdate = $this->request->getRawInput();
        if(isset($propToUpdate['card_id'])){
           $patient =  (new PatientService)->setCard($id,$propToUpdate['card_id']);
           return is_null($patient)?$this->fail("No existe el paciente"):$this->respondUpdated($patient);
        }
        
        $person->fill($this->request->getRawInput());

        try {
            $save = $this->personModel->save($person);
        } catch (\ReflectionException | DataException $e) {
            return $this->fail($e->getMessage());
        }

        return $save ?
            $this->respondUpdated($person) : $this->fail($this->personModel->errors());

    }
}
