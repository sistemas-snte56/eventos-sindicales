<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders en orden lógico
        $this->call([
            RegionSeeder::class,
            DelegacionSeeder::class,
            MunicipioSeeder::class,
            ColoniaSeeder::class,
            RolesSeeder::class,
        ]);

        $this->command->info('✔ Base de datos sembrada exitosamente.');        

    }
}
