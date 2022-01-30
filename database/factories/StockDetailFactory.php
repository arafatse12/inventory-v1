<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockDetailFactory extends Factory
{
    protected $model = StockDetail::class;

    public function definition()
    {
        $stock = Stock::pluck('id');
        $product = Product::pluck('id');
        return [
            'stock_id' => $this->faker->randomElement($stock),
            'product_id' => $this->faker->randomElement($product),
            'quantity' => rand(1,10),
            'amount' => rand(50,1000),
            'purchase_price' => rand(50,1000),
            'sell_price' => rand(50,1000),
            'markup' => rand(1,10),
        ];
    }
}
