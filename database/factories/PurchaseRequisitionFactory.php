<?php

namespace Database\Factories;

use App\Models\Office;
use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseRequisitionFactory extends Factory
{
    protected $model = PurchaseRequisition::class;

    public function definition()
    {
        $officeId = office::pluck('id');
        return [
            'remark' => $this->faker->realText(180),
            'status' => "Pending",
            'date' => now(),
            'office_id' => $this->faker->randomElement($officeId)
        ];
    }
}
