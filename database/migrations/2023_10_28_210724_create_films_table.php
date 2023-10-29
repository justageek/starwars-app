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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 191);
            $table->integer('episode_id');
            $table->mediumText('opening_crawl');
            $table->string('director', 191);
            $table->string('producer', 191);
            $table->date('release_date');
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
        Schema::dropIfExists('films');
    }
};
