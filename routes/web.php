<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Percepcao\PercepcaoShow;
use App\Http\Livewire\Percepcao\PercepcaoCreate;
use App\Http\Livewire\Percepcao\PercepcaoAvaliacaoCreate;
use App\Http\Livewire\Percepcao\PercepcaoAvaliacaoShow;
use App\Http\Livewire\Percepcao\GrupoCreate;

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
Route::get('/avaliar', PercepcaoAvaliacaoCreate::class)->middleware('auth');
Route::get('/avaliar/preview/{idPercepcao}', PercepcaoAvaliacaoCreate::class)->middleware('auth');
Route::get('/gestao-sistema/percepcao', PercepcaoShow::class)->middleware('auth');
Route::get('/gestao-sistema/percepcao/create-livewire', PercepcaoCreate::class)->middleware('auth');
Route::get('/gestao-sistema/percepcao/create-grupo', GrupoCreate::class)->middleware('auth');
