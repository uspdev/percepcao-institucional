<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePercepcaoAvaliacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percepcao_avaliacaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('percepcao_id')->constrained()->onDelete('restrict');
            $table->integer('ministranteDaDisciplina');
            $table->string('codigoDaDisciplina', 10);
            $table->string('nomeDaDisciplina');
            $table->integer('versaoDaDisciplina');
            $table->string('codigoDaTurma', 10);
            $table->string('tipoDaTurma');
            $table->integer('assiduidadePontualidade');
            $table->integer('apresentacaoCumprimentoDoPlanoDeEnsino');
            $table->integer('conhecimentoAtualizacaoDaMateria');
            $table->integer('utilizacaoDaBibliografiaBasicaNaDisciplina');
            $table->integer('clarezaNaExposicaoDosConteudos');
            $table->integer('relacionamentoEntreAspectosTeoricosEPraticosDaDisciplina');
            $table->integer('didaticaDinamismoClarezaEOrganizacaoNaExposicaoDeTemasNasAulas');
            $table->integer('coerenciaEntreConteudoMinistradoEAvaliacoesAplicadas');
            $table->integer('interesseEmEsclarecerAsDuvidasDosAlunos');
            $table->integer('relacionamentoComOsAlunos');
            $table->integer('assiduidadePontualidadeAluno');
            $table->integer('compromissoAluno');
            $table->integer('participacaoNasAulasAluno');
            $table->integer('relacionamentoComOsColegasProfessoresEPessoalAdministrativoAluno');
            $table->integer('cumprimentoDasAtividadesRecomendadasAluno');
            $table->text('comentariosESugestoesDoAluno')->nullable();
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
        Schema::dropIfExists('percepcao_avaliacaos');
    }
}
