<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostas', function (Blueprint $table) {
            $table->id();
            $table->ForeignId('percepcao_id')->constrained()->onDelete('restrict');
            $table->ForeignId('grupo_id')->constrained()->onDelete('restrict');
            $table->ForeignId('questao_id')->constrained()->onDelete('restrict');
            $table->ForeignId('disciplina_id')->nullable()->constrained()->onDelete('restrict');
            $table->ForeignId('coordenador_id')->nullable()->constrained()->onDelete('restrict');
            $table->ForeignId('user_id')->constrained()->onDelete('restrict');
            $table->integer('codpes');
            $table->text('resposta')->nullable();
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
        Schema::dropIfExists('respostas');
    }
}
