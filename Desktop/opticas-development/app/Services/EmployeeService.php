<?php

namespace App\Services;

use App\Entities\Employee;
use App\Models\EmployeeModel;

class EmployeeService
{


    protected EmployeeModel $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    public static function getEmployeeByUser($id): ?Employee
    {
        return model(EmployeeModel::class)
            ->select("users.username, persons.*")
            ->join("users","users.id = employees.user")
            ->join("persons","persons.id = employees.person","left")
            ->where("employees.user",$id)
            ->withDeleted()
            ->first();
    }
}