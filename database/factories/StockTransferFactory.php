<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Office;
use App\Models\StockTransfer;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockTransferFactory extends Factory
{
    protected $model = StockTransfer::class;

    public function definition()
    {
        $officeId = Office::pluck('id');
        $stock = Stock::pluck('id');
        return [
            'stock_id' => $this->faker->randomElement($stock),
            'office_id_from' => $this->faker->randomElement($officeId),
            'office_id_to' => $this->faker->randomElement($officeId),
            'status' => "Transit"
        ];
    }
}
