<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('parking_spaces', function (Blueprint $table) {
            $table->id();
            $table->uuid('vehicle_id');
            $table->foreignId('vehicle_type_id');
            $table->boolean('is_occupied')->default(false);
            $table->timestamp('parked_on');
            $table->timestamp('left_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parking_spaces');
    }
};