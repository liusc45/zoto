<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyModel;
use App\Models\ContractModel;
use CodeIgniter\HTTP\ResponseInterface;

class Contract extends Company
{
    private string $type = 'contract';


    public function __construct()
    {
        parent::__construct($this->type);
        $this->companyModel = new ContractModel();
    }

}
