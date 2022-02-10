<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePercepcaoAvaliacaoComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percepcao_avaliacao_comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('percepcao_id')->constrained()->onDelete('restrict');
            $table->text('comentariosESugestoesGerais')->nullable();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('percepcao_avaliacao_comentarios');
    }
}
