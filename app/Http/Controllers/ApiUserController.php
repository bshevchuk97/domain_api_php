<?php

namespace App\Http\Controllers;

use App\Models\Session;
use dateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ApiUser;
use Response;
use Throwable;


class ApiUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $username = $request->get("username");
        $password_hash = $request->get("password_hash");

        if (!self::correctUserCredentials($username, $password_hash))
            return Response::json(['error' => 'You must specify both username and password hash'], 401);
        $user = ApiUser::where('username', '=', $username)->first();

        if ($user != NULL)
            return Response::json(['error' => 'User already exists!'], 401);

        try {
            $new_user = $this->createUser($username, $password_hash);
            $session = $this->createSession($new_user);

            return Response::json(['session_token' => $session->token]);
        } catch (Throwable $e) {
            return Response::json(['message' => $e->getMessage()], 401);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $username = $request->get("username");
        $password_hash = $request->get("password_hash");

        if (!self::correctUserCredentials($username, $password_hash))
            return Response::json(['error' => 'You must specify both username and password hash'], 401);
        $user = ApiUser::where('username', '=', $username)->first();

        if ($user == NULL)
            return Response::json(['error' => 'User does not exist!'], 401);

        try {
            $session = $this->createSession($user);
            return Response::json(['session_token' => $session->token]);
        } catch (Throwable $e) {
            return Response::json(['message' => $e->getMessage()], 401);
        }
    }

//      /**
//     * Update the specified resource in storage.
//     *
//     * @param Request $request
//     * @param int $id
//     * @return Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        //
//    }

    private static function correctUserCredentials($username, $password_hash): bool
    {
        return $username != NULL && $password_hash != NULL;
    }

    private function createUser($username, $password_hash): ApiUser
    {
        $new_user = new ApiUser();
        $new_user->username = $username;
        $new_user->password_hash = $password_hash;

        $new_user->save();
        return $new_user;
    }

    private function createSession($user): Session
    {
        srand(time());
        $session = new Session();
        $session->token = md5(mt_rand() . $user->username);
        $session->created = new dateTime();
        $session->user()->associate($user);

        $session->save();
        return $session;
    }
}
