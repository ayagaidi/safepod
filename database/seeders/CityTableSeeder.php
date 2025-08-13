<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'طرابلس'],
            ['name' => 'بنغازي'],
            ['name' => 'مصراتة'],
            ['name' => 'الزاوية'],
            ['name' => 'سبها'],
            ['name' => 'سرت'],
            ['name' => 'البيضاء'],
            ['name' => 'زليتن'],
            ['name' => 'درنة'],
            ['name' => 'اجدابيا'],
            ['name' => 'غريان'],
            ['name' => 'طبرق'],
            ['name' => 'الكفرة'],
            ['name' => 'يفرن'],
            ['name' => 'نالوت'],
            ['name' => 'شحات'],
            ['name' => 'براك الشاطئ'],
            ['name' => 'وادي عتبة'],
            ['name' => 'مرزق'],
            ['name' => 'غات'],
            ['name' => 'زوارة'],
            ['name' => 'المرج'],
            ['name' => 'مسلاتة'],
            ['name' => 'الخمس'],
            ['name' => 'ترهونة'],
            ['name' => 'بني وليد'],
            ['name' => 'الواحات'],
            ['name' => 'الجفرة'],
            ['name' => 'الجميل'],
            ['name' => 'رقدالين'],
            ['name' => 'العجيلات'],
            ['name' => 'الرياينة'],
            ['name' => 'القره بوللي'],
            ['name' => 'قصر بن غشير'],
            ['name' => 'السواني'],
            ['name' => 'الماية'],
            ['name' => 'الزنتان'],
            ['name' => 'الرجبان'],
            ['name' => 'الاصابعة'],
            ['name' => 'الشكشوك'],
            ['name' => 'الحرابة'],
            ['name' => 'القلعة'],
            ['name' => 'بئر الغنم'],
            ['name' => 'بئر الأشهب'],
            ['name' => 'أم الأرانب'],
            ['name' => 'الفقهاء'],
        ];

        DB::table('cities')->insert($cities);
    }
}
