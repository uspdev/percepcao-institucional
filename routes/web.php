<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Percepcao\PercepcaoShow;
use App\Http\Livewire\Percepcao\PercepcaoCreate;
use App\Http\Livewire\Percepcao\PercepcaoAddQuestao;
use App\Http\Livewire\Percepcao\PercepcaoAvaliacaoCreate;
use App\Http\Livewire\Percepcao\PercepcaoAvaliacaoShow;
use App\Http\Livewire\Percepcao\GrupoCreate;
use App\Http\Livewire\Percepcao\QuestaoCreate;

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
    Route::middleware('can:gerente')->group(function () {
        Route::get('/avaliar', PercepcaoAvaliacaoCreate::class);
        Route::get('/avaliar/preview/{idPercepcao}', PercepcaoAvaliacaoCreate::class);
        Route::get('/gestao-sistema/percepcao', PercepcaoShow::class);
        Route::get('/gestao-sistema/percepcao/{idPercepcao}/add-questao', PercepcaoAddQuestao::class);
        Route::get('/gestao-sistema/percepcao/create-livewire', PercepcaoCreate::class);
        Route::get('/gestao-sistema/percepcao/create-grupo', GrupoCreate::class);
        Route::get('/gestao-sistema/percepcao/create-questao', QuestaoCreate::class);
    });
});
