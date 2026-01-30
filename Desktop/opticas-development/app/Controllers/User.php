<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Controllers\RegisterController;
use CodeIgniter\Shield\Exceptions\ValidationException;

class User extends RegisterController
{
    use ResponseTrait;
    public function index()
    {
        $users = auth()
            ->getProvider()
            ->select("users.*, auth_identities.secret as email, ")
            ->join("auth_identities","auth_identities.user_id = users.id")
           // ->getCompiledSelect(false);
            ->findAll();

        return $this->respond($users);
    }
    public function show($id): ResponseInterface
    {
        $user  =auth()
            ->getProvider()
            ->select("users.*, auth_identities.secret")
            ->join("auth_identities","auth_identities.user_id = users.id")
            ->findById($id);
        return $this->respond($user);
    }

    public function create(): ResponseInterface
    {
        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return $this->failForbidden("Forbidden",null,lang('Auth.registerDisabled'));
        }

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return $this->failValidationErrors( $this->validator->getErrors());
        }

        // Save the user
        //$allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost());

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return $this->fail($e->getMessage());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        //$users->addToDefaultGroup($user);
        $userGroup = $this->request->getPost("group")??"employee";
        $user->addGroup($userGroup);

        Events::trigger('register', $user);

        /** @var Session $authenticator */
  //      $authenticator = auth('session')->getAuthenticator();

       // $authenticator->startLogin($user);

        // If an action has been defined for register, start it up.
/*        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->route('auth-action-show');
        }*/

        // Set the user active
        $user->activate();

        //$authenticator->completeLogin($user);

        // Success!
        return $this->respondCreated($user);
    }

    public function update($id): ResponseInterface
    {
        $users = auth()->getProvider();
        $user = $users->findById($id);

        $user->fill($this->request->getRawInput());
        try {

            $updated = $users->save($user);
        } catch (\ReflectionException $e   ) {
            return $this->fail($e->getMessage());
        }
        return $updated ?  $this->respondUpdated($user) : $this->fail($users->errors());

    }
    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted(auth()->getProvider()->delete($id));
    }
    public function myStore()
    {
       
        $store = model("StoreModel")->find($this->request->getPost("id"));
        session()->remove("store");
        session()->set("store",$store);
        return $this->respondCreated(session("store"));
    }
}
