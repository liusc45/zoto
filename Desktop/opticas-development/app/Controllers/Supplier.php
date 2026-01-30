<?php

namespace App\Controllers;


use App\Models\SupplierModel;

class Supplier extends Company
{
    private string $type = 'supplier';
    protected SupplierModel $supplierModel;

    public function __construct()
    {
        parent::__construct($this->type);
        $this->companyModel = new SupplierModel();
        //$this->supplierModel = new SupplierModel();
    }

    public function update($id): \CodeIgniter\HTTP\ResponseInterface
    {
        $supplier = $this->supplierModel->find($id);
        if(!is_null($supplier)){
           // $company = $this->companyModel->find($supplier->company->id);
//            $company->fill($this->request->getRawInput());
//            $this->companyModel->update($id, $this->request->getRawInput());
        }

        return parent::update($supplier->company->id);

    }


}
