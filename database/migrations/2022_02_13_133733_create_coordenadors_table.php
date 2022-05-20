<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordenadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordenadors', function (Blueprint $table) {
            $table->id();
            $table->integer('codpes');
            $table->string('nompes');
            $table->integer('codcur');
            $table->string('nomcur');
            $table->integer('codhab');
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
        Schema::dropIfExists('coordenadors');
    }
}
