<?php

namespace Database\Seeders;

use App\Models\StockDetail;
use Illuminate\Database\Seeder;

class StockDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StockDetail::factory()->count(100)->create();
    }
}
