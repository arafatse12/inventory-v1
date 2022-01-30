<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $unit = config('enums.unit_types');
        $categoryId = ProductCategory::pluck('id');
        $supplierId = Supplier::pluck('id');
        $brandId = Brand::pluck('id');
        return [
            'product_category_id' => $this->faker->randomElement($categoryId),
            'item_code' => uniqid(),
            'name' => $this->faker->name(),
            'unit' =>  $this->faker->randomElement($unit),
            'reorder_qty' => rand(1,10),
            'max_discount' => rand(1,10),
            'purchase_price' => rand(50,1000),
            'markup' => rand(1,10),
            'sell_price' => rand(50,1000),
            'supplier_id' => $this->faker->randomElement($supplierId),
            'brand_id' => $this->faker->randomElement($brandId),
            'tax' => rand(1,10),
        ];
    }
}
