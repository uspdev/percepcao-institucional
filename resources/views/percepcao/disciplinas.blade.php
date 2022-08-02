@extends('layouts.app')

@section('content')
  <h2 class="">
    <a class="" href="{{ route('percepcao.show', $percepcao) }}">
      {{ $percepcao->settings['nome'] }} ({{ $percepcao->ano }}/{{ $percepcao->semestre }})
    </a>
    @include('percepcao.partials.badge-situacao')

    <i class="fas fa-angle-right"></i> Disciplinas
    <span class="badge badge-primary badge-pill">{{ $percepcao->settings['totalDeDisciplinas'] }}</span>

    @if ($percepcao->isFuturo())
      <div class="ml-3">
        <form method="POST" action="{{ route('percepcao.disciplinas.update', $percepcao->id) }}">
          @csrf
          <input type="hidden" name="acao" value="atualizar">
          <button type="submit" class="btn btn-warning">Recarregar do replicado</button>
        </form>
      </div>
    @endif

  </h2>

  <table class="table table-sm table-bordered datatable">
    <thead>
      <tr>
        <th>Código</th>
        <th>Nome</th>
        <th>Turma</th>
        <th>Versão</th>
        <th>Tipo</th>
        <th>Professor</th>
        <th>Setor</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($disciplinas as $disciplina)
        <tr>
          <td>{{ $disciplina['coddis'] }}</td>
          <td>{{ $disciplina['nomdis'] }}</td>
          <td>{{ $disciplina['codtur'] }}</td>
          <td>{{ $disciplina['verdis'] }}</td>
          <td>{{ $disciplina['tiptur'] }}</td>
          <td>{{ $disciplina['nompes'] }}</td>
          <td>{{ $disciplina['nomabvset'] }}/{{ $disciplina['sglund'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Disciplinas de <span class="nome-do-aluno">"aluno"</span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascripts_bottom')
  <script>
    $(document).ready(function() {

      $('#exampleModal').on('show.bs.modal', function(event) {
        var modal = $(this)
        var button = $(event.relatedTarget) // Button that triggered the modal

        modal.find('.nome-do-aluno').text(button.data('nompes'))
        $.get(
          'gestao-sistema/percepcao/{{ $percepcao->id }}/alunos/' + button.data('codpes'),
          function(data) {
            modal.find('.modal-body').html(data)
          })
      })
    })
  </script>
@endsection
