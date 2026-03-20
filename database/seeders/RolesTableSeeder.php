<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
        ['name' => 'admin', 'display_name' => 'Администратор'],
        ['name' => 'moderator', 'display_name' => 'Модератор'],
        ['name' => 'user', 'display_name' => 'Пользователь'],
    ];

    foreach ($roles as $roleData) {
        // Мы ищем по имени, и если не находим — создаем с полным набором данных
        Role::firstOrCreate(
            ['name' => $roleData['name']], 
            $roleData
        );
    }

        $this->command->info('✅ Роли успешно созданы!');
    }
}
