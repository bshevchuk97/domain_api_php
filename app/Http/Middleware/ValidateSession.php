<?php

namespace App\Http\Middleware;

use App\Service\Session\SessionValidator;
use Closure;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;

class ValidateSession extends Middleware
{

    protected $except = [
        'register',
        'login'
    ];

    /**
     * @throws Exception
     */
    public function handle($request, Closure $next, ...$guards) {
        if (!in_array($request->path(), $this->except)) {
            $validator = new SessionValidator($request->bearerToken());

            if (!$validator->isValid()) {
                throw new SessionNotFoundException();
            }
            return $next($request);
        }

        return $next($request);
    }
}
