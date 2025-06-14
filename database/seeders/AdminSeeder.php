<?php

namespace Database\Seeders;

use App\Models\System\Permission;
use App\Models\System\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menentukan role Administrator
        $adminRole = Role::firstOrCreate([
            'name' => 'Administrator',
            // 'slug_name' => 'administrator',
        ]);

        // Menambahkan user Administrator
        User::create([
            'fullname' => 'Hai Ojan',
            'role' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'verify_at' => now(),
            'phone' => '081912488040'
        ]);

        $routes = Route::getRoutes()->getRoutesByName();

        foreach ($routes as $routeName => $route) {
            // Simpan routeName dan URL ke tabel permissions
            Permission::create([
                'url' => $routeName, // Menggunakan nama rute sebagai identifikasi
                'role_id' => $adminRole->id // Set default jobLvl, ini dapat diubah sesuai kebutuhan Anda
            ]);
        }
    }
}
