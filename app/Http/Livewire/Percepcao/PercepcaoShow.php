<?php

namespace App\Http\Livewire\Percepcao;

use Livewire\Component;
use App\Models\Percepcao;

class PercepcaoShow extends Component
{
    public $selectedId;
    public $action;
    public $columns;
    public $sortField = 'id';
    public $sortDirection = 'asc';

    protected $listeners = [
      'refreshParent' => '$refresh'
    ];

    public function mount()
    {
        $this->columns = $this->setColumns();
    }

    public function selectedId($id, $action)
    {
        $this->selectedId = $id;
        $this->action = $action;

        if($this->action == "create") {
            $this->selectedId = '';
        }

        $this->emit('getUpdateId', $this->selectedId, $this->action);
    }

    public function setColumns()
    {
        return [
            [
                'name' => 'id',
                'text' => 'No.',
                'sortable' => true,
            ],
            [
                'name' => 'dataDeAbertura',
                'text' => 'Abertura',
                'sortable' => true,
            ],
            [
                'name' => 'dataDeFechamento',
                'text' => 'Fechamento',
                'sortable' => false,
            ],
            [
                'name' => 'ano',
                'text' => 'Ano',
                'sortable' => false,
            ],
            [
                'name' => 'semestre',
                'text' => 'Semestre',
                'sortable' => false,
            ],
            [
                'name' => 'totalDeAlunosMatriculados',
                'text' => 'Alunos matriculados',
                'sortable' => false,
            ],
            [
                'name' => 'liberaConsultaMembrosEspeciais',
                'text' => 'Libera membros especiais?',
                'sortable' => false,
            ],
            [
                'name' => 'liberaConsultaDocente',
                'text' => 'Libera docentes?',
                'sortable' => false,
            ],
            [
                'name' => 'liberaConsultaAluno',
                'text' => 'Libera alunos?',
                'sortable' => false,
            ],
            [
                'name' => 'comentario',
                'text' => 'Comentário',
                'sortable' => false,
            ],
        ];
    }

    public function sort($field)
    {
        $this->sortField = $field;
        $this->sortDirection = ($this->sortDirection == "asc") ? "desc" : "asc";
    }

    public function delete()
    {
        Percepcao::destroy($this->selectedId);
    }

    public function render()
    {
        return view('livewire.percepcao.percepcao-show', [
          'percepcoes' => Percepcao::orderBy($this->sortField, $this->sortDirection)->get(),
        ])->extends('layouts.app')->section('content');
    }
}
