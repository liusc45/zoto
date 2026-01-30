<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Pin extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        //
    }

    public function auth(): ResponseInterface
    {
       $pin = $this->request->getPost("pin");
       $savedPin = $this->getPin();
       return  $pin === $savedPin ? $this->respond(["valid"=>true]) : $this->failUnauthorized();

    }

    public function getPin()
    {
        $pin = setting()->get("discount.pin");
        if(is_null($pin)) {
            $pin = 1111;
        }
        return $pin;

    }
    public function main(): string
    {
        $data = [
            'title' => 'PIN de descuento',
            'pin' => $this->getPin(),
        ];
        return view("components/pin/main", $data);
    }

    public function update(): ResponseInterface
    {
        $data = $this->request->getRawInput();

        // Basic validation: required and 4 digits numeric
        if ($data["pin"] === null || !preg_match('/^\d{4,6}$/', (string)$data["pin"])) {
            session()->setFlashdata('error', );
            return $this->fail('El PIN debe ser numérico de 4 a 6 dígitos.');
        }

        try {
            setting()->set('discount.pin', (string)$data["pin"]);

        } catch (\Throwable $e) {
            log_message('error', 'Error al actualizar PIN: {message}', ['message' => $e->getMessage()]);
            return $this->fail( 'No se pudo actualizar el PIN.');
        }

        return $this->respond(["pin"=>$data["pin"],"message"=>"PIN actualizado correctamente."]);
    }
}
