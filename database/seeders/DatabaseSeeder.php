<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            WargaSeeder::class,
            RWSeeder::class,
            RTSeeder::class,
            KeluargaSeeder::class,
            KepemilikanSeeder::class,
            LevelSeeder::class,
            UserSeeder::class,
            KKWarga::class,
        ]);
    }
}
