<?php

namespace Database\Seeders;

use App\Models\System\Permission;
use App\Models\System\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class RoleEmployee extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'user'
        ]);
    }
}
