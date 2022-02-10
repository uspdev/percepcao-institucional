<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Percepcao\PercepcaoShow;
use App\Http\Livewire\Percepcao\PercepcaoCreate;
use App\Http\Livewire\Percepcao\PercepcaoAvaliacaoCreate;
use App\Http\Livewire\Percepcao\PercepcaoAvaliacaoShow;

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
Route::get('/percepcao-institucional', PercepcaoAvaliacaoShow::class)->middleware('auth');
Route::get('/percepcao-institucional/avaliar', PercepcaoAvaliacaoCreate::class)->middleware('auth');
Route::get('/percepcao-institucional/gestao-sistema/percepcao', PercepcaoShow::class)->middleware('auth');
Route::get('/percepcao-institucional/gestao-sistema/percepcao/create-livewire', PercepcaoCreate::class)->middleware('auth');
