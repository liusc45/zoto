<?php

namespace App\Services;

use App\Entities\Person;
use App\Models\PersonModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use ReflectionException;

class PersonService
{
    protected PersonModel $model;
    public function __construct()
    {
        $this->model = new PersonModel();

    }

    /**
     * set a person from a request
     *
     * @throws ReflectionException
     * @throws DataException
     * @param IncomingRequest $request
     * @return Person
     */
    public function setPerson(IncomingRequest $request):Person
    {
        $this->model->save(new Person([
            "name" => $request->getPost("name"),
            "last_name" =>$request->getPost("last_name"),
            "dob" =>$request->getPost("dob")===''?null:$request->getPost("dob"),
            "main_phone" =>$request->getPost("main_phone"),
            "email" =>$request->getPost("email"),
            "street" => $request->getPost("street"),
            "city" =>$request->getPost("city"),
            "state" =>$request->getPost("state"),
            "postal_code" =>$request->getPost("postal_code"),
            "occupation" =>$request->getPost("occupation"),
        ]));
        return $this->model->find($this->model->getInsertID());

    }
}
