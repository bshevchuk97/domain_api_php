<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Service\Session\SessionService;
use App\Service\User\UserService;
use dateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ApiUser;
use Response;
use Throwable;


class ApiUserController extends Controller
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct(UserService $userService, SessionService $sessionService) {
        $this->userService = $userService;
        $this->sessionService = $sessionService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse {
        $user = $this->userService
                     ->register($request->get('username'),
                                $request->get('password_hash'));

        return Response::json(['session'=>$this->sessionService->create($user)
                                                               ->token]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse {
        $user = $this->userService
                     ->login($request->get('username'),
                             $request->get('password_hash'));

        return Response::json(['session'=>$this->sessionService->create($user)
                                                               ->token]);
    }
}
