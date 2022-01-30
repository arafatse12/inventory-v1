<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OfficeTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(StockSeeder::class);
        $this->call(StockDetailSeeder::class);
        $this->call(StockTransferSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(SaleDetailSeeder::class);
        $this->call(PurchaseRequisitionSeeder::class);
        $this->call(PurchaseRequisitionProductSeeder::class);
        User::factory()->count(30)->create();

        $this->command->alert("<comment>(:---------------Users Credentials---------------:)</comment>");

        foreach (User::all() as $user) {
            $this->command->info("Email: {$user->username} | Password: 123456");
        }

        $this->command->alert("<comment>(:-----------------(:Successfully:)-----------------------:)</comment>");
    }
}
