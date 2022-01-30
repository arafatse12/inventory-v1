<?php

namespace Database\Seeders;

use Str;
use App\Models\User;
use App\Models\Office;
use Illuminate\Database\Seeder;
use App\Repositories\OfficeRepo;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;

class UserRoleSeeder extends Seeder
{

    public function run()
    {
        $status = Config::get('enums.user_status')[0];
        $role = Role::create(['name' => 'Super admin']);
        $officeId = Office::where('type','Head Office')->first()->id;
        $user = User::create(
            [
                'name' => 'Md Super Admin',
                'email' => 'superadmin@gmail.com',
                'username' => 'superadmin',
                'status' => $status,
                'office_id' => 1,
                'email_verified_at' => now(),
                'password' => bcrypt(123456),
                'phone' => '0123456789',
                'address' =>  'Mirpur, Dhaka', 
                'remember_token' => Str::random(10),
            ]
        );
        $user->assignRole($role);
        $role->givePermissionTo(Permission::all());
    }
}
