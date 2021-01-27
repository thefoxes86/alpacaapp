<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllevamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allevamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('piva')->nullable();
            $table->string('indirizzo')->nullable();
            $table->string('cap',5)->nullable();
            $table->string('citta');
            $table->string('provincia');
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('nome');
            $table->string('logo')->default('/img/AllevamentoDefaultProfile.svg');
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
        Schema::dropIfExists('allevamentos');
    }
}
