<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = SaleDetail::class;

    public function definition()
    {
        $sale = Sale::pluck('id');
        $product = Product::pluck('id');
        return [
            'sale_id' => $this->faker->randomElement($sale),
            'product_id' => $this->faker->randomElement($product),
            'quantity' => rand(1,10),
            'sell_amount' => rand(50,1000),
            'purchase_amount' => rand(50,1000),
            'total' => rand(50,1000),
        ];
    }
}
