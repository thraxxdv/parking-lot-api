<?php

namespace Database\Seeders;

use App\Models\ParkingSpace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GateSeeder::class,
            VehicleTypeSeeder::class
        ]);
        ParkingSpace::factory(15)->create();
    }
}
