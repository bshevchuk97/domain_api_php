<?php

namespace App\Exceptions;

use Egulias\EmailValidator\Validation\Exception\EmptyValidationList;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Phalcon\Exception;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $e)
    {
        /*if ($request->ajax() || $request->wantsJson())
        {
            $json = [
                'success' => false,
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
            ];

            return response()->json($json, 400);
        }

        return parent::render($request, $e);*/
        if ($e instanceof ModelNotFoundException/* && $request->wantsJson()*/) {
            return response()->json(['error' => 'Not Found!'], 404);
        }
        elseif ($e instanceof SessionNotFoundException) {
            return response()->json(['error' => 'Session is either nonexistent or expired'], 401);
        }
        elseif ($e instanceof AuthorizationException) {
            return response()->json(['error' => 'Session is either nonexistent or expired'], 401);
        }
        elseif ($e instanceof  EmptyValidationList){
            return response()->json(['error' => 'You must specify both username and password hash'], 401);
        }
        elseif ($e instanceof  UserNotFoundException){
            return response()->json(['error' => 'Specified user not found'], 401);
        }
        elseif ($e instanceof UserAlreadyExistsException){
            return response()->json(['error' => 'User with such name already exists'], 401);
        }
        else
            return response()->json(['error' => $e->getMessage()], 500);


        /*return parent::render($request, $e);*/
    }

}
