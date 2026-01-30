<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Company extends BaseController
{
    use ResponseTrait;
    private string|null $type ;
    protected $companyModel;

    public function __construct($type = null)
    {
        $this->type = $type ;
        $this->companyModel = new CompanyModel();

        if($this->type!==null) {
            $this->companyModel->where(["type" => $this->type]);
        }
    }


    public function index(): ResponseInterface
    {
        return $this->respond($this->companyModel
            ->findAll());
    }


    public function show($id): ResponseInterface
    {
        return $this->respond($this->companyModel->find($id));
    }

    public function create(): ResponseInterface
    {
        $entity =  ucfirst($this->type);

        $class = "\App\Entities\\".$entity;
        $company = new $class([
            "name"=>$this->request->getPost("name"),
            "type"=>$this->type,
            "contact"=>$this->request->getPost("contact"),
            "address"=>$this->request->getPost("address"),
            "phone"=>$this->request->getPost("phone")
        ]);

        try {
            $inserted = $this->companyModel->save($company);


        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        $lastId = $this->companyModel->getInsertID();
        return $inserted  ?
            $this->respondCreated($this->companyModel->find($lastId)) :
            $this->fail($this->companyModel->errors());
    }
    public function update($id):ResponseInterface
    {
        $company = $this->companyModel->find($id);

        $company->fill($this->request->getRawInput());

        try {
            $updated = $this->companyModel->save($company);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }

        return $updated? $this->respondUpdated($company): $this->fail($this->companyModel->errors());

    }

    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted( $this->companyModel->delete($id));
    }
}
