<?php

namespace Database\Factories;

use App\Models\ApiUser;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Session::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token'=>$this->faker->md5(),
            'created'=>$this->faker->dateTime()
        ];
    }

    public function withToken($token){
        return [
            'token'=>$token
        ];
    }


}
