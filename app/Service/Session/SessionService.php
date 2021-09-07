<?php

namespace App\Service\Session;

use App\Models\User;
use App\Models\Session;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;

class SessionService
{
    public function __construct(){

    }


    public function create(User $user){
        return Session::create($user);
    }


    public function find(?string $token){
        if(empty($token)){
            throw new SessionNotFoundException();
        }

        return Session::findToken($token)->first();
    }
}
