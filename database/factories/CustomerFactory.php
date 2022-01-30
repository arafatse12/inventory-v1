<?php

namespace Database\Factories;

use App\Models\Office;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Customer::class;

    public function definition()
    {
        $officeId = Office::pluck('id');
        return [
            'name' => $this->faker->name(),
            'mobile' =>  '09'.$this->faker->randomKey([000000000, 999999999]),
            'office_id' =>  $this->faker->randomElement($officeId),
        ];

    }
}
