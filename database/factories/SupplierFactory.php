<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'contact_name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'mobile' =>  '09'.$this->faker->randomKey([000000000, 999999999]),
            'email' =>$this->faker->safeEmail(),
        ];
    }
}
