<?php

namespace App\Service\User;

use App\Exceptions\UserAlreadyExistsException;
use App\Exceptions\UserNotFoundException;
use App\Models\ApiUser;
use Cassandra\Exception\AlreadyExistsException;
use Egulias\EmailValidator\Validation\Exception\EmptyValidationList;
use Illuminate\Container\EntryNotFoundException;

class UserValidator
{
    /**
     * @throws UserAlreadyExistsException
     */
    public function validateCreation($username, $password_hash) {
        if (!self::correctUserCredentials($username, $password_hash)) {
            throw new EmptyValidationList();
        }
        if ($this->userExists($username, $password_hash)) {
            throw new UserAlreadyExistsException();
        }
    }

    /**
     * @throws UserNotFoundException
     */
    public function validateLogin($username, $password_hash) {
        if (!self::correctUserCredentials($username, $password_hash)) {
            throw new EmptyValidationList();
        }
        if (!$this->userExists($username, $password_hash)) {
            throw new UserNotFoundException();
        }
    }


    private function userExists($username, $password_hash): bool {
        return ApiUser::where(['username'=>$username])->exists();
    }


    private static function correctUserCredentials($username, $password_hash): bool {
        return !empty($username) && !empty($password_hash);
    }
}
