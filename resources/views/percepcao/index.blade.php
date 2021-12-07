@extends('templates.template')

@section('content')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#percepcaoModal">
  Cadastrar Percepção Institucional
</button>
<br><br>

<h2 class="text-center font-weight-bold">Lista de percepções</h2>
<hr>

<table id="example" class="table table-stripped table-hover table-bordered datatable-demo responsive">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Número</th>
      <th>Abertura</th>
      <th>Fechamento</th>
      <th>Ano</th>
      <th>Semestre</th>
      <th>Alunos matriculados</th>
      <th>Libera membros especiais?</th>
      <th>Libera docentes?</th>
      <th>Libera alunos?</th>
    </tr>
  </thead>
  <tbody>
@forelse($percepcoes as $percepcao)
    <tr>
      <td></td>
      <td>{{ $percepcao->id ?? '' }}</td>
      <td>{{ $percepcao->dataAbertura->format('d/m/Y H:i') ?? '' }}</td>
      <td>{{ $percepcao->dataFechamento->format('d/m/Y H:i') ?? '' }}</td>
      <td>{{ $percepcao->ano ?? '' }}</td>
      <td>{{ $percepcao->semestre ?? '' }}</td>
      <td>{{ $percepcao->totalAlunosMatriculados ?? '' }}</td>
      <td>{{ $percepcao->liberaConsultaMembrosEspeciais ?? '' }}</td>
      <td>{{ $percepcao->liberaConsultaDocente ?? '' }}</td>
      <td>{{ $percepcao->liberaConsultaAluno ?? '' }}</td>
    </tr>
@endforeach
  </tbody>
</table>

@section('javascripts_bottom')
<script>
    $(document).ready(function() {
        $('.datatable-demo').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json'
            }
        });
    } );
</script>
@endsection

@include('percepcao.partials.modal')

@endsection
