<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Stock;
use App\Models\Office;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Sale::class;

    public function definition()
    {
        $officeId = Office::pluck('id');
        $customerid = Customer::pluck('id');
        $stockId = Stock::pluck('id');
        $paymentMode = config('enums.sales_payment_mode');
        $paymentStatus = config('enums.sales_payment_status');
        return [
            'customer_id' => $this->faker->randomElement($customerid),
            'stock_id' => $this->faker->randomElement($stockId),
            'total_amount' => rand(50,100),
            'discount_percent' => rand(1,100),
            'discount_amount' => rand(1,100),
            'payment_amount' => rand(1,1000),
            'change_amount' => rand(1,1000),
            'payment_mode' => $this->faker->randomElement($paymentMode),
            'bank_name' => 'City Bank',
            'checque_no' => rand(1,1000),
            'status' => $this->faker->randomElement($paymentStatus),
            'office_id' => $this->faker->randomElement($officeId),
        ];
    }
}
