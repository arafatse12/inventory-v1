<?php

namespace Database\Factories;

use App\Models\Office;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{

    public function definition()
    {
        $status = Config::get('enums.user_status')[0];
        $officeId = Office::pluck('id');
        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'status' => $status,
            'office_id' => $this->faker->randomElement($officeId),
            'password' => bcrypt(123456),
            'phone' => $this->faker->phoneNumber,
            'address' =>  $this->faker->address(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
