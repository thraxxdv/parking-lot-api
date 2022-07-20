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
            $table->uuid('vehicle_id')->nullable();
            $table->foreignId('vehicle_type_id');
            $table->boolean('is_occupied')->default(false);
            $table->foreignId('occupying_vehicle_type')->nullable();
            $table->timestamp('parked_on')->nullable();
            $table->timestamp('left_on')->nullable();
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