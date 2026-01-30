<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Discount extends BaseController
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
       return $this->respond( $pin === $savedPin);
    }

    public function getPin()
    {
        $pin = setting()->get("discount.pin");
        if(is_null($pin)) {
            $pin = 1111;
        }
        return $pin;

    }
    public function main()
    {
        $data = [
            'title' => 'PIN de descuento',
            'pin' => $this->getPin(),
        ];
        return view("components/discount/main", $data);
    }

    public function updatePin()
    {
        $newPin = $this->request->getPost('pin');

        // Basic validation: required and 4 digits numeric
        if ($newPin === null || !preg_match('/^\d{4,6}$/', (string)$newPin)) {
            session()->setFlashdata('error', 'El PIN debe ser numérico de 4 a 6 dígitos.');
            return redirect()->to('/descuentos/pin');
        }

        try {
            setting()->set('discount.pin', (string)$newPin);
            session()->setFlashdata('success', 'PIN actualizado correctamente.');
        } catch (\Throwable $e) {
            log_message('error', 'Error al actualizar PIN: {message}', ['message' => $e->getMessage()]);
            session()->setFlashdata('error', 'No se pudo actualizar el PIN.');
        }

        return redirect()->to('/descuentos/pin');
    }
}
