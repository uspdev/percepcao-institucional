<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePercepcaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percepcao', function (Blueprint $table) {
            $table->id();
            $table->timestamp('dataAbertura')->nullable();
            $table->timestamp('dataFechamento')->nullable();
            $table->integer('ano');
            $table->integer('semestre');
            $table->integer('totalAlunosMatriculados')->nullable();
            $table->enum('liberaConsultaMembrosEspeciais', ['Sim', 'Não'])->default('Não');
            $table->enum('liberaConsultaDocente', ['Sim', 'Não'])->default('Não');
            $table->enum('liberaConsultaAluno', ['Sim', 'Não'])->default('Não');
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
        Schema::dropIfExists('percepcao');
    }
}
