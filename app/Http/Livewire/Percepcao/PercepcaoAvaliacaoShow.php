<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Percepcao;
use App\Models\PercepcaoAvaliacao;

class PercepcaoAvaliacaoShow extends Component
{
    public $percepcao;
    public $percepcaoEnvio;
    public $statusPercepcao = null;

    public function mount() {

        if($this->percepcao = Percepcao::obterAberto()) {
            if($this->percepcao->dataDeAbertura > date('Y-m-d H:i:s')) {
                $this->statusPercepcao = "A Percepção Institucional estará disponível a partir de: " . $this->percepcao->dataDeAbertura->format('d/m/Y \à\s H:i:s') . ".";
            }

            if($this->percepcao->dataDeFechamento < date('Y-m-d H:i:s')) {
                $this->statusPercepcao = "A Percepção Institucional deste semestre foi finalizada em: " . $this->percepcao->dataDeFechamento->format('d/m/Y \à\s H:i:s') . ".<br />Obrigado pela sua colaboração.";
            }

            $this->percepcaoEnvio = PercepcaoAvaliacao::where('percepcao_id', $this->percepcao->id)->where('user_id', Auth::id())->first();
        }
        else {
            $this->statusPercepcao = "Nenhuma existe nenhuma Percepção Institucional cadastrada no momento!";
        }
    }

    public function render()
    {
        return view('livewire.percepcao.percepcao-avaliacao-show',[
            'percepcao' => $this->percepcao,
            'percepcaoEnvio' => $this->percepcaoEnvio,
            'statusPercepcao' => $this->statusPercepcao,
        ])->extends('layouts.app')->section('content');
    }
}
