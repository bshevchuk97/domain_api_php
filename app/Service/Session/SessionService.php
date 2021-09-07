<?php

namespace App\Service\Session;

use App\Models\ApiUser;
use App\Models\Session;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;

class SessionService
{
    public function __construct(){

    }


    public function create(ApiUser $user){
        return Session::create($user);
    }


    public function find(?string $token){
        if(empty($token)){
            throw new SessionNotFoundException();
        }

        return Session::findToken($token)->first();
    }
}
