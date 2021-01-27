<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlpacasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alpacas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('colore')->unsigned();
            $table->integer('madre')->nullable();
            $table->integer('padre')->nullable();
            $table->integer('allevatore')->unsigned()->nullable();     
            $table->date('nascita');
            $table->string('microchip')->unique()->nullable();
            $table->date('morte')->nullable();
            $table->integer('tipologia')->unsigned();    
            $table->string('sesso',1);
            $table->string('immagine')->default('/img/AlpacaDefaultProfile.svg');
            $table->longText('galleria')->nullable();
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
        Schema::dropIfExists('alpacas');
    }
}
