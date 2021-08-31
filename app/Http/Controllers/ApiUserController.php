<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ApiUser;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\Types\Integer;

class ApiUserController extends Controller
{

    private static function correctUserCredentials($username, $password_hash): bool
    {
        return $username != NULL && $password_hash != NULL;
    }

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
            return \Response::json(['error' => 'You must specify both username and password hash'], 401);

        $user = ApiUser::where('username', '=', $username)->first();

        if ($user != NULL)
            return \Response::json(['error' => 'User already exists!'], 401);

        $new_user = new ApiUser();
        $new_user->username = $username;
        $new_user->password_hash = $password_hash;

        try {
            $new_user->save();
        } catch (\Throwable $e) {
            return \Response::json(['message' => $e->getMessage()], 401);
        }

        return \Response::json($username);
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $username = $request->get("username");
        $password_hash = $request->get("password_hash");

        if (!self::correctUserCredentials($username, $password_hash))
            return \Response::json(['error' => 'You must specify both username and password hash'], 401);

        $user = ApiUser::where('username', '=', $username)->first();

        if ($user == NULL)
            return \Response::json(['error' => 'User does not exist!'], 401);

        srand(time());
        $session = new Session();
        $session->token = md5(strval(mt_rand()) . $username);
        $session->created = new \dateTime();
        $session->user()->associate($user);

        try {
            $session->save();
        } catch (\Throwable $e) {
            return \Response::json(['message' => $e->getMessage()], 401);
        }

        return \Response::json(['session_token' => $session->token]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
