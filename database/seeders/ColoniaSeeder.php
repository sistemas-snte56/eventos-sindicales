<?php

namespace Database\Seeders;

use App\Models\Colonia;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColoniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $path = database_path('seeders/data/colonias.csv');

        if (!file_exists($path)) {
            $this->command->warn('El archivo colonias.csv no fue encontrado.');
            return;
        }

        $colonias = array_map('str_getcsv', file($path));

        foreach ($colonias as $index => $row) {
            if ($index === 0) continue; // Omitir cabecera

            Colonia::updateOrCreate(
                ['id' => $row[0]],
                [
                    'municipio_id' => $row[1],
                    'nombre' => $row[2],
                    'codigo_postal' => $row[3],
                ]
            );
        }

        $this->command->info('Colonias importadas correctamente.');       

    }
}
