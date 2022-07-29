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
        Schema::create('percepcaos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('dataDeAbertura')->nullable();
            $table->timestamp('dataDeFechamento')->nullable();
            $table->integer('ano');
            $table->integer('semestre');
            $table->boolean('liberaConsultaMembrosEspeciais')->default(0);
            $table->boolean('liberaConsultaDocente')->default(0);
            $table->boolean('liberaConsultaAluno')->default(0);
            $table->json('questao_settings')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('percepcaos');
    }
}
