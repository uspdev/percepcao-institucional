<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplinas', function (Blueprint $table) {
            $table->id();
            $table->integer('codpes');
            $table->string('nompes', 120);
            $table->string('nomabvset', 15);
            $table->string('sglund', 7);
            $table->string('coddis');
            $table->string('nomdis');
            $table->integer('verdis');
            $table->string('codtur');
            $table->string('tiptur');
            $table->ForeignId('percepcao_id')->constrained()->onDelete('restrict');
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
        Schema::dropIfExists('disciplinas');
    }
}
