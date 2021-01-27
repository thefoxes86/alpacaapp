<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titolo');
            $table->string('immagine')->default('/img/EventDefaultPicture.svg');
            $table->text('contenuto')->nullable();
            $table->string('indirizzo');
            $table->string('lat');
            $table->string('lon');
            $table->date('data');
            $table->boolean('approved')->default(false);
            $table->integer('user')->unsigned();
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
        Schema::dropIfExists('eventos');
    }
}
