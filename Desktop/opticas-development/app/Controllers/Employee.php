<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PatientModel;
use App\Models\PersonModel;
use App\Services\PersonService;
use App\Services\UserService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Models\DatabaseException;

class Employee extends BaseController
{
    use ResponseTrait;
    protected PersonModel $personModel;
    protected EmployeeModel $employeeModel;


    private array $levels = [
        "admin"=>"Administrador",
        "doctor"=>"Doctor",
        "employee"=>"Empleado",
        "seller"=>"Vendedor",
    ];
    public function __construct()
    {
        $this->personModel = new PersonModel();
        $this->employeeModel = new EmployeeModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respond( $this->employeeModel
            ->select([
                "persons.*",
                "users.username",
                "employees.id as employee",
                "employees.user",
                "employees.store",
                
            ])
            ->join("persons","persons.id = employees.person","left")
            ->join("users","employees.user = users.id")

            ->findAll());
    }

    public function show($id): ResponseInterface
    {
        return $this->respond($this->employeeModel->find($id));
    }

    public function create(): ResponseInterface
    {
        $user = null;
        try {
            
            
            $person = (new PersonService)->setPerson($this->request);
            if(!is_null($this->request->getPost("email"))) {
                $user = (new UserService)->setUser($this->request, $this->request->getPost("group_users"));
            }
        
            $employee = new \App\Entities\Employee([
                "person"=>$person->id,
                "user"=>$user?->id,
                "store"=> $this->request->getPost("store")?? session("store")?->id??0 ,
            ]);
            $saved = $this->employeeModel->save($employee);
        } catch (\ReflectionException| DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
        return $saved ?
            $this->respondCreated($this->employeeModel->find($this->employeeModel->getInsertID())):
            $this->fail($this->employeeModel->errors());

    }

    public function delete(int $id): ResponseInterface
    {
        $employee = $this->employeeModel->withDeleted()->find($id);
        $this->employeeModel->delete($employee->id);
        return $this->respondDeleted($employee);
    }


    public function main(): string
    {
        return view("components/employee/main",[
            "levels"=>$this->levels,
        ]);
    }
}
