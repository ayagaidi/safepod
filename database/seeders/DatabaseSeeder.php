<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PolicySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ContactusesTableSeeder::class);

        $this->call(ContactusesTableSeeder::class);
        // $this->call(ExchangesTypesSeeder::class);

        $this->call(CityTableSeeder::class);
         $this->call(CreateAdminUserSeeder::class);
         $this->call(OrderStatuesSeeder::class);
         $this->call(PolicySeeder::class);

         
            

    }
}
