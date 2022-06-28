<?php

namespace App\Http\Controllers;

use App\Models\Percepcao;
use Illuminate\Http\Request;
use App\Models\PercepcaoAvaliacao;

class AvaliacaoController extends Controller
{
    public function index()
    {
        // $this->authorize('user');
        $users = \App\Models\User::with('permissions')->get();
        // dd($users->toArray());

        $statusPercepcao = null;
        $percepcaoEnvio = null;

        if ($percepcao = Percepcao::obterAtivo()) {
            if ($percepcao->dataDeAbertura > date('Y-m-d H:i:s')) {
                $statusPercepcao = "A Percepção Institucional estará disponível a partir de: "
                    . $percepcao->dataDeAbertura->format('d/m/Y \à\s H:i:s') . ".";
            }

            if ($percepcao->dataDeFechamento < date('Y-m-d H:i:s')) {
                $statusPercepcao = "A Percepção Institucional deste semestre foi finalizada em: "
                    . $percepcao->dataDeFechamento->format('d/m/Y \à\s H:i:s') . ".<br />Obrigado pela sua colaboração.";
            }

            $percepcaoEnvio = PercepcaoAvaliacao::where('percepcao_id', $percepcao->id)->where('user_id', \Auth::id())->first();
        } else {
            $statusPercepcao = "Não existe Percepção Institucional cadastrada no momento!";
        }

        return view('index', compact('percepcao', 'statusPercepcao', 'percepcaoEnvio'));
    }
}
