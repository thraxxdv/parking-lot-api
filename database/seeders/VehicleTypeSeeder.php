<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleType::insert([
                ['id' => 1, 'type'  => 'S', 'rate' => 20],
                ['id' => 2, 'type'  => 'M', 'rate' => 60],
                ['id' => 3, 'type'  => 'L', 'rate' => 100],
            ],
        );
    }
}
