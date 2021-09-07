<?php

namespace App\Http\Middleware;
use App\Models\User;
use App\Models\Session;
use App\Service\Session\SessionValidator;
use Illuminate\Support\Facades\Route;
use DateTime;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use function Psy\debug;

class SessionProvider
{
    /**
     * @throws Exception
     */
    public function currentSession(): Session {
        $sessionToken = Route::getCurrentRequest()->bearerToken();
        return Session::findToken($sessionToken)->first();
    }

    public function currentUser(): User {
        $sessionToken = Route::getCurrentRequest()->bearerToken();
        $user = Session::findToken($sessionToken)->user;

        return $user;
    }


    public function create(User $user): Session {
        return Session::create($user);
    }
}
