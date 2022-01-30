<?php

namespace Database\Seeders;

use App\Models\SaleDetail;
use Illuminate\Database\Seeder;

class SaleDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SaleDetail::factory()->count(40)->create();
    }
}
