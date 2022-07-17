<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->char('type', 1);
            $table->timestamps();
        });

        DB::table('vehicle_types')->insert([
                ['id' => 1, 'type'  => 'S'],
                ['id' => 2, 'type'  => 'M'],
                ['id' => 3, 'type'  => 'L'],
            ],
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_types');
    }
};
