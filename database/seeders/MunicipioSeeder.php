<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/municipios.csv');

        if (!file_exists($path)) {
            $this->command->warn('El archivo municipios.csv no fue encontrado.');
            return;
        }

        $municipios = array_map('str_getcsv', file($path));

        foreach ($municipios as $index => $row) {
            if ($index === 0) continue; // Omitir cabecera

            Municipio::updateOrCreate(
                ['id' => $row[0]],
                ['nombre' => $row[1]]
            );
        }

        $this->command->info('Municipios importados correctamente.');
    }
}
