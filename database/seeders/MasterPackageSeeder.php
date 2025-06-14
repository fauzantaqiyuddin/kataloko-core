<?php
namespace Database\Seeders;

use App\Models\MasterData\MasterPackage;
use Illuminate\Database\Seeder;

class MasterPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterPackage::create([
            'name'        => "Paket 3 Bulan",
            'description' => 'Berlangganan selama 3 bulan',
            'duration'    => 90,
            'price'       => 500000,
            'isTrial'     => false,
            'access'      => [],
        ]);
    }
}
