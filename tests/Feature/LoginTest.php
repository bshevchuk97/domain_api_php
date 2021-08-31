<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function correctLoginTest()
    {
        $response = $this->postJson('/login', ['username' => 'Kalisto', 'password_hash' => '38138a01cbafd1674182e47ec6f0760e']);

        $response->assertStatus(200);
        $response->assertJsonStructure(['session_token']);
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function emptyUsernameTest(){
        $response = $this->postJson('/login', ['username' => '', 'password_hash' => '38138a01cbafd1674182e47ec6f0760e']);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'You must specify both username and password hash']);
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function emptyPasswordHashTest(){
        $response = $this->postJson('/login', ['username' => 'Kalisto', 'password_hash' => '']);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'You must specify both username and password hash']);
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function nullUsernameTest(){
        $response = $this->postJson('/login', ['password_hash' => '38138a01cbafd1674182e47ec6f0760e']);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'You must specify both username and password hash']);
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function nullPasswordHashTest(){
        $response = $this->postJson('/login', ['username' => 'Kalisto']);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'You must specify both username and password hash']);
    }


}
