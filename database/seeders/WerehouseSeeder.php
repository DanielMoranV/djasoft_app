<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run()
    {
        Warehouse::create([
            'name' => 'Almacén Principal',
            'location' => 'Sullana, Ignacio Escudero',
            'phone' => '948860381',
            'company_id' => 1
        ]);
    }
}