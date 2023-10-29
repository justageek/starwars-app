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
        Schema::create('starships', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 191);
            $table->string('model', 191);
            $table->string('manufacturer', 191);
            $table->string('cost_in_credits', 191);
            $table->integer('length');
            $table->string('max_atmosphering_speed', 191);
            $table->string('crew', 191);
            $table->string('passengers', 191);
            $table->string('cargo_capacity', 191);
            $table->string('consumables', 191);
            $table->string('hyperdrive_rating', 191);
            $table->string('mglt', 191);
            $table->string('starship_class', 191);
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
        Schema::dropIfExists('starships');
    }
};
