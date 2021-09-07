<?php

namespace App\Service\User;

use App\Exceptions\UserAlreadyExistsException;
use App\Exceptions\UserNotFoundException;
use App\Models\User;

final class UserService
{
    private UserValidator $userValidator;

    public function __construct(UserValidator $userValidator) {
        $this->userValidator = $userValidator;
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function register(string $username, string $password_hash): User {
        $this->userValidator->validateCreation($username, $password_hash);
        return User::create($username, $password_hash);
    }

    /**
     * @throws UserNotFoundException
     */
    public function login(string $username, string $password_hash): User {
        $this->userValidator->validateLogin($username, $password_hash);
        return User::login($username, $password_hash);
    }
}
