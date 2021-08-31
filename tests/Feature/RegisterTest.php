<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ApiUser;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    private static $existingUser = 'Kalisto';
    private static $existingPasswordHash = '38138a01cbafd1674182e47ec6f0760e';

    /**
     * @param int $length
     * @return false|string
     */
    private function generateUsername(int $length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            ceil($length / strlen($x)))), 1, $length);
    }

    /**
     * @param string $phrase
     * @return string
     */
    private function generatePasswordHash(string $phrase = 'stub'): string
    {
        srand(time());
        return md5(mt_rand() . $phrase);
    }

    /**
     * @test
     */
    public function registerNewUserTest()
    {
        $newUser = $this->generateUsername(10);
        $newPassHash = $this->generatePasswordHash($newUser);
        $response = $this->postJson('/register', ['username' => $newUser, 'password_hash' => $newPassHash]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['session_token']);

        $user = ApiUser::where(['username' => $newUser, 'password_hash' => $newPassHash])->delete();
        /*$user = ApiUser::where(['username' => self::$existingUser, 'password_hash' => self::$existingPasswordHash]);*/
    }

    /**
     * @test
     */
    public function registerExistingUserTest()
    {
        $response = $this->postJson('/register', ['username' => self::$existingUser,
                                                      'password_hash' => self::$existingPasswordHash]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'User already exists!']);
    }

    /**
     * @test
     */
    public function nullUsernameRegisterTest()
    {
        $response = $this->postJson('/register', ['password_hash' => self::$existingPasswordHash]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'You must specify both username and password hash']);
    }

    /**
     * @test
     */
    public function nullPasswordHashRegisterTest()
    {
        $response = $this->postJson('/register', ['username' => self::$existingUser]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'You must specify both username and password hash']);
    }

    /**
     * @test
     */
    public function emptyUsernameRegisterTest()
    {
        $response = $this->postJson('/register', ['username' => '',
            'password_hash' => self::$existingPasswordHash]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'You must specify both username and password hash']);
    }

    /**
     * @test
     */
    public function emptyPasswordHashRegisterTest()
    {
        $response = $this->postJson('/register', ['username' => self::$existingUser,
            'password_hash' => '']);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'You must specify both username and password hash']);
    }
}
