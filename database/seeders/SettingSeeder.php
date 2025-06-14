<?php

namespace Database\Seeders;

use App\Models\System\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'maintenance' => 'disable',
            'url_hris' => 'https://api-pharma.kalbe.co.id'
        ]);
    }
}
