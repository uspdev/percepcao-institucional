@extends('layouts.app')

@section('content')
  <h2 class="">
    <a href="{{ route('percepcaos.index') }}">Percepções</a>
    <i class="fas fa-angle-right"></i> {{ $percepcao->settings['nome'] }}
    ({{ $percepcao->ano }}/{{ $percepcao->semestre }})

    {!! $percepcao->isAberto() ? '<span class="badge badge-primary">Aberto</span>' : '' !!}
    {!! $percepcao->isFinalizado() ? '<span class="badge badge-secondary">Finalizado</span>' : '' !!}
    {!! $percepcao->isFuturo() ? '<span class="badge badge-success">Em elaboração</span>' : '' !!}
  </h2>

  <div class="card">
    <div class="card-body">
      <p>
        Período: de <b>{{ $percepcao->dataDeAbertura->format('d/m/Y H:i') }}</b> à
        <b>{{ $percepcao->dataDeFechamento->format('d/m/Y H:i') }}</b>
      </p>
      <p>
        <a href="{{ route('avaliar.preview', $percepcao->id) }}">
          <i class="fas fa-eye"></i>
          Visualização prévia do questionário
        </a>
      </p>
      <p>
        <a href="{{ route('percepcao.questoes', $percepcao->id) }}">
          <i class="fas fa-question-circle"></i>
          Adicionar/editar questões
        </a>
      </p>
      <p>
        Alunos matriculados: {{ $percepcao->settings['totalDeAlunosMatriculados'] }}
        <i class="fas fa-angle-right"></i>
        <a href="{{ route('percepcao.alunos', $percepcao->id) }}">
          <i class="fas fa-eye"></i>
          ver lista
        </a>
      </p>
      <p>
        Turmas: {{ $percepcao->settings['totalDeDisciplinas'] }}
        <i class="fas fa-angle-right"></i>
        <a href="{{ route('percepcao.disciplinas', $percepcao->id) }}">
          <i class="fas fa-eye"></i>
          ver lista
        </a>
      </p>
    </div>
  </div>

  <div class="row mt-3">

    <div class="col-md-6">
        @include('percepcao.partials.show-especiais')
    </div>
  </div>
@endsection
