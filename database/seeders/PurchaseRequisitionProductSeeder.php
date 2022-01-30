<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseRequisitionProduct;

class PurchaseRequisitionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchaseRequisitionProduct::factory()->count(40)->create();
    }
}
