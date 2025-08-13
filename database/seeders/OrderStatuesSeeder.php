<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatuesSeeder extends Seeder
{
    public function run()
    {
        // Insert default order statues
        DB::table('order_statues')->insert([
            ['name' => 'قيد الانتظار'],    // Pending
            ['name' => 'قيد التنفيذ'],    // Processing
            ['name' => 'مكتمل'],          // Completed
            ['name' => 'ملغي'],           // Cancelled
        ]);
    }
}
