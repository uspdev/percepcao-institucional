@extends('layouts.app')

@section('content')
  <h2>
    <a href="gestao-sistema/percepcao">Percepções</a>
    <i class="fas fa-angle-right"></i> Alunos {{ $percepcao->ano }}/{{ $percepcao->semestre }}
    <span class="badge badge-primary badge-pill">{{ count($alunos) }}</span>
  </h2>
  <table class="table table-sm table-bordered">
    <thead>
      <tr>
        <th>Unidade</th>
        <th>Ingresso</th>
        <th>Curso</th>
        <th>No. USP</th>
        <th>Nome</th>
        <th>Disciplinas</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($alunos as $aluno)
        <tr>
          <td>{{ $aluno['sglund'] }}</td>
          <td class="text-center">
            {{ \Carbon\Carbon::Create($aluno['dtainivin'])->format('Y') }}
          </td>
          <td>
            {{ $aluno['nomcur'] }}
          </td>
          <td>
            {{ $aluno['codpes'] }} <span
              class="badge badge-pill badge-secondary">{{ count($aluno['disciplinas']) }}</span>
          </td>
          <td>
            <a href="#" data-toggle="modal" data-target="#exampleModal" data-codpes="{{ $aluno['codpes'] }}"
              data-nompes="{{ $aluno['nompes'] }}">
              {{ $aluno['nompes'] }}
            </a>
          </td>
          <td>
            @foreach ($aluno['disciplinas'] as $disciplina)
              {{ $disciplina['coddis'] }} - {{ $disciplina['codtur'] }} -
              {{ $disciplina['nomdis'] }}<br>
            @endforeach
          </td>
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
