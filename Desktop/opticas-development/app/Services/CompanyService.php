<?php

namespace App\Services;

use App\Models\CompanyModel;

class CompanyService
{
    protected CompanyModel $companyModel;
    public function __construct()
    {
        $this->companyModel = new CompanyModel();
    }

    public function getCompany(){

    }
}