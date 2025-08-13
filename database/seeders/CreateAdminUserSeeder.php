<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use  App\Models\User;

use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $user = User::create([
        	'username' => 'superadmin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'cities_id' => '1',
            'email' => 'superadmin@safepod.ly',
            'password' => bcrypt('12345678'),
            'phonenumber' => '920000000',
            'active'=>1,
        ]);
        
  
        
    }
}
