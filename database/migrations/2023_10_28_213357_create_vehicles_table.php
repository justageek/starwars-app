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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 191);
            $table->string('model', 191);
            $table->string('manufacturer', 191);
            $table->string('cost_in_credits', 191);
            $table->string('length', 191);
            $table->string('max_atmosphering_speed', 191);
            $table->string('crew', 191);
            $table->string('passengers', 191);
            $table->string('cargo_capacity', 191);
            $table->string('consumables', 191);
            $table->string('vehicle_class', 191);
            $table->datetime('api_created');
            $table->datetime('api_edited');
            $table->string('api_url', 191);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
