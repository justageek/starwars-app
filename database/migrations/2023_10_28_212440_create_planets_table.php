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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name', 191);
            $table->integer('rotation_period');
            $table->integer('orbital_period');
            $table->integer('diameter');
            $table->string('climate', 191);
            $table->string('gravity', 191);
            $table->string('terrain', 191);
            $table->string('surface_water', 191);
            $table->string('population', 191);
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
        Schema::dropIfExists('planets');
    }
};
