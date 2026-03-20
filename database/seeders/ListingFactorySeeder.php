<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
class ListingFactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔹 Базовые справочники
        
        // $cities = ['Алматы', 'Астана', 'Шымкент', 'Актобе', 'Караганда'];
        // foreach ($cities as $c) {
        //     City::firstOrCreate(['name' => $c]);
        // }
        // foreach (City::all() as $city) {
        //     for ($i = 1; $i <= 3; $i++) {
        //         $city->districts()->firstOrCreate(['name' => "Район {$i}"]);
        //     }
        // }
        $types = ['Квартира', 'Дом', 'Участок', 'Коммерческая', 'Офис'];
        foreach ($types as $t) {
            Type::firstOrCreate(['name' => $t]);
        }

        // // 🔹 10 пользователей
        // \App\Models\User::factory(10)->create();

        // // 🔹 30 объявлений
        // \App\Models\Listing::factory(30)->create();

        // $this->command->info('✅ Добавлено: 10 пользователей, 30 объявлений, 5 городов.');
    }
}
