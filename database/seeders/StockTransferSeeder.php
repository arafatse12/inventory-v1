<?php

namespace Database\Seeders;

use App\Models\StockTransfer;
use Illuminate\Database\Seeder;

class StockTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StockTransfer::factory()->count(40)->create();
    }
}
