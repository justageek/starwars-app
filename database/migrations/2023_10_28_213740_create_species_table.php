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
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 191);
            $table->string('classification', 191);
            $table->string('designation', 191);
            $table->string('average_height', 191);
            $table->string('skin_colors', 191);
            $table->string('hair_colors', 191);
            $table->string('eye_colors', 191);
            $table->string('average_lifespan', 191);
            $table->string('homeworld_url', 191)->nullable();
            $table->string('language', 191);
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
        Schema::dropIfExists('species');
    }
};
