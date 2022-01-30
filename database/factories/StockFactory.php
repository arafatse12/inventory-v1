<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition()
    {
        // $officeId = Office::pluck('id');
        $officeId = [1,2,3];
        return [
            'stock_type' => 'Recipte',
            'is_opening' => 'No',
            'posting_date_time' => now(),
            'stock_date' => now(),
            'office_id' => $this->faker->randomElement($officeId),
            'purchase_order_id' => NULL,
            'stock_transcation' => 'In',
        ];
    }
}
