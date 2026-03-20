<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolesTableSeeder::class,
            ListingFactorySeeder::class,
            
        ]);
        \App\Models\User::factory()->create([
            'phone' => '+77027897120',
            'email' => 'zhusup1964@gmail.com',
            'name'  => 'Jusup Alimbetov',
            'password' => Hash::make('Jusup_Alimbetov_1964'),
            'role_id' => 1,
            'is_admin' => true,
        ]);
        \App\Models\User::factory()->create([
            'phone' => '+77077801011',
            'email' => 'almuko.m@gmail.com',
            'name'  => 'Mukhtar',
            'password' => Hash::make('Zxcvbnm123'),
            'role_id' => 1,
            'is_admin' => true,
        ]);
        
//        $this->call( RolesTableSeeder::class);
    }
}
