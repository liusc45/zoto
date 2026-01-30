<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class SaleItem extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        //
    }
    
    public function create()
    {
        $sale = $this->request->getPost("sale");
        $cart =array_filter($this->request->getPost("cart"));
        
       $items =  new \App\Entities\SaleItem($this->request->getPost());
       log_message("info",json_encode($sale));
        return $this->respond($cart );
    }
}
