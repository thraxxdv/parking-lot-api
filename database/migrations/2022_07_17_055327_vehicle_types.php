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
            $table->float('rate');
            $table->timestamps();
        });

        DB::table('vehicle_types')->insert([
                ['id' => 1, 'type'  => 'S', 'rate' => 20],
                ['id' => 2, 'type'  => 'M', 'rate' => 60],
                ['id' => 3, 'type'  => 'L', 'rate' => 100],
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
