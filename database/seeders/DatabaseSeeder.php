<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ManajemenDataMutu::class,
            Users::class,
            KaryawanSeeder::class,
            Indikator::class,
            KamusIndikator::class,
            IndikatorPeriodeSeeder::class,
        ]);
    }
}
