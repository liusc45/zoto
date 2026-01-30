<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\ContactBrands;
use App\Database\Migrations\ContactColors;
use App\Database\Migrations\ContactDesigns;
use App\Database\Migrations\ContactWears;
use App\Models\CompanyModel;
use App\Models\ContactBrandModel;
use App\Models\ContactColorModel;
use App\Models\ContactDesignModel;
use App\Models\ContactModel;
use App\Models\ContactWearModel;
use App\Models\SupplierModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Contact extends BaseController
{
    use ResponseTrait;
    protected ContactModel $contactModel;
    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    public function index()
    {
        $contacts = $this->contactModel
            ->select([
                "contacts.id",
                "contacts.name",
                "contacts.units_per_package",
                "companies.name as supplier_name",
                "contact_designs.name as design_name",
                "contact_colors.name as color_name",
                "contact_wears.name as wear_name",
                "contact_brands.name as brand_name",
                "contacts.replace_unit",
                "contacts.replace_time",
            ])
            ->join("companies","companies.id = contacts.supplier")
            ->join("contact_designs","contact_designs.id = contacts.design")
            ->join("contact_colors","contact_colors.id = contacts.color")
            ->join("contact_wears","contact_wears.id = contacts.wear")
            ->join("contact_brands","contact_brands.id = contacts.brand")
            ->findAll();
        return $this->respond($contacts);
    }

    public function new()
    {
        return view('components/contact/main',[
            "suppliers" => model(CompanyModel::class)->where(["type"=>"supplier"])->findAll(),
            "brands"=> model(ContactBrandModel::class)->findAll(),
            "colors"=> model(ContactColorModel::class)->findAll(),
            "designs"=> model(ContactDesignModel::class)->findAll(),
            "wears"=> model(ContactWearModel::class)->findAll(),
            "contacts" => $this->contactModel->findAll(),

        ]);
    }
}
