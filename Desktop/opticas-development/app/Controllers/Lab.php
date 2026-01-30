<?php

namespace App\Controllers;

use App\Models\LabModel;

class Lab extends Company
{
    private string $type = 'lab';
    public function __construct()
    {
        parent::__construct($this->type);
        $this->companyModel = new LabModel();

    }


}
