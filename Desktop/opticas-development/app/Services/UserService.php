<?php

namespace App\Services;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Shield\Entities\User;
use Faker\Provider\Person;

class UserService
{

    public function setUser (RequestInterface $request,$group ):User
    {
        $user =  new \CodeIgniter\Shield\Entities\User([
            "username" => $this->getUsername($request->getPost("email")),
            "email" => $request->getPost("email"),
            "password" => $request->getPost("password")??'paciente.25',
            "confirm_password" => $request->getPost("confirm_password")??'paciente.25',
        ]);
        $userModel = auth()->getProvider();
        $userModel->save($user);
        $user->id = $userModel->getInsertID();
        $user->addGroup($group);
        return $user;
    }
    private  function getUsername(string $email):string
    {
        return explode('@', $email)[0];
    }

}