<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->date('year')->nullable();;
            $table->string('rotten_score')->nullable();
            $table->string('imdb_score')->nullable();
            $table->string('director');
            $table->string('trailer')->nullable();
            $table->text('synopsis');
            $table->string('genres');
            $table->string('poster')->nullable();
            $table->timestamps();
        });

        Schema::create('qualities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resolution');
            $table->integer('movie_id');
            $table->timestamps();
        });

        Schema::create('similars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('movie_id');
            $table->integer('other_movie_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
        Schema::dropIfExists('qualities');
        Schema::dropIfExists('similars');
    }
}
