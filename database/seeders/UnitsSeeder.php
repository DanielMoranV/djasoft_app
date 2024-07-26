<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            ['nombre' => 'Kilogramo', 'symbol' => 'kg'],
            ['nombre' => 'Gramo', 'symbol' => 'g'],
            ['nombre' => 'Litro', 'symbol' => 'l'],
            ['nombre' => 'Mililitro', 'symbol' => 'ml'],
            ['nombre' => 'Metro', 'symbol' => 'm'],
            ['nombre' => 'Centímetro', 'symbol' => 'cm'],
            ['nombre' => 'Unidad', 'symbol' => 'u'],
            ['nombre' => 'Caja', 'symbol' => 'caja'],
            ['nombre' => 'Paquete', 'symbol' => 'paquete'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}