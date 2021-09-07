<?php

namespace App\Service\User;

use App\Exceptions\UserAlreadyExistsException;
use App\Exceptions\UserNotFoundException;
use App\Models\ApiUser;

final class UserService
{
    private UserValidator $userValidator;

    public function __construct(UserValidator $userValidator) {
        $this->userValidator = $userValidator;
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function register(string $username, string $password_hash): ApiUser {
        $this->userValidator->validateCreation($username, $password_hash);
        return ApiUser::create($username, $password_hash);
    }

    /**
     * @throws UserNotFoundException
     */
    public function login(string $username, string $password_hash): ApiUser {
        $this->userValidator->validateLogin($username, $password_hash);
        return ApiUser::login($username, $password_hash);
    }
}
