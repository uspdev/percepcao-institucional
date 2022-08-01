<?php

namespace App\Http\Controllers;

use App\Models\Resposta;
use App\Models\Percepcao;
use Illuminate\Http\Request;
use App\Models\PercepcaoAvaliacao;

class AvaliacaoController extends Controller
{
    public function index()
    {
        $percepcao = Percepcao::obterAberto();
        return view('index', compact('percepcao'));
    }
}
