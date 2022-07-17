<?php

namespace Database\Seeders;

use App\Models\Gate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gate::insert([
            ['nearest_space' => 9],
            ['nearest_space' => 6],
            ['nearest_space' => 3],
        ]);
    }
}
