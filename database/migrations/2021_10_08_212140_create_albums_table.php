<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('album_name');
            $table->foreignId('artist_id')->references('id')->on('artists');
            $table->foreignId('genre_id')->references('id')->on('genres');
            $table->date('release_date');
            $table->string('label')->nullable();
            $table->string('country')->nullable();
            $table->string('album_cover')->nullable();
            $table->boolean('confirmed')->default(0);
            $table->unique(['album_name', 'artist_id']);
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
        Schema::dropIfExists('albums');
    }
}
