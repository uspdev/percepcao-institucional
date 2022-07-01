<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Percepcao\PercepcaoShow;
use App\Http\Livewire\Percepcao\PercepcaoCreate;
use App\Http\Livewire\Percepcao\PercepcaoAddQuestao;
use App\Http\Livewire\Percepcao\PercepcaoAvaliacaoShow;
use App\Http\Livewire\Percepcao\GrupoCreate;
use App\Http\Livewire\Percepcao\RelatorioShow;

use App\Http\Livewire\Questao\Create as QuestaoCreate;
use App\Http\Livewire\AvaliacaoCreate;

use App\Http\Controllers\percepcaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', PercepcaoAvaliacaoShow::class);

Route::middleware('auth')->group(function () {
    Route::get('/avaliar', AvaliacaoCreate::class);

    Route::middleware('can:gerente')->group(function () {
        Route::get('/avaliar/preview/{idPercepcao}', AvaliacaoCreate::class);

        Route::get('percepcoes', PercepcaoShow::class)->name('percepcaos.index');
        // Route::get('/gestao-sistema/percepcao/{idPercepcao}/add-questao', PercepcaoAddQuestao::class);
        // Route::get('/gestao-sistema/percepcao/create-livewire', PercepcaoCreate::class);
        
        Route::get('/gestao-sistema/percepcao/create-grupo', GrupoCreate::class);
        Route::get('/gestao-sistema/percepcao/create-questao', QuestaoCreate::class);

        Route::get('/gestao-sistema/percepcao/consulta/disciplinas', RelatorioShow::class);
        Route::get('/gestao-sistema/percepcao/consulta/coordenadores', RelatorioShow::class);

        Route::get('/gestao-sistema/percepcao/{percepcao}/alunos', [PercepcaoController::class, 'alunos'])->name('percepcao.alunos');
        Route::get('/gestao-sistema/percepcao/{percepcao}/alunos/{codpes}', [PercepcaoController::class, 'listarDisciplinasAluno'])->name('percepcao.alunos.disciplinas');

        Route::get('/gestao-sistema/percepcao/{percepcao}/disciplinas', [PercepcaoController::class, 'disciplinas'])->name('percepcao.disciplinas');
        Route::post('/gestao-sistema/percepcao/{percepcao}/disciplinas', [PercepcaoController::class, 'disciplinasUpdate'])->name('percepcao.disciplinas.update');
    });
});
