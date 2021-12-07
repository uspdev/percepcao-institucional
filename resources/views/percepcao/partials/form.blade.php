@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
@endsection
<div class="container">
  <h2 class="text-center font-weight-bold">Cadastro de Percepção Institucional</h2>
  <hr>
  <form name="percepcao" id="percepcaoForm">
    @csrf
    @if(isset($percepcao->id))
      @method('patch')
    @endif()
    <div class="container" style="max-width: 450px">
      <div class="form-group">
        <label>Ano:</label>
        <input type="text" name="ano" class="form-control" value="{{ old('ano', $percepcao->ano) }}" >
      </div>
      <div class="form-group">
        <label>Semestre:</label>
        <input type="text" name="semestre" class="form-control" value="{{ old('semestre', $percepcao->semestre) }}" >
      </div>
      <div class="form-group">
        <label>Data de abertura:</label>
        <div class='input-group date' id='dataAbertura'>
          <input type='text' class="form-control" name="dataAbertura" >
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
      <div class="form-group">
        <label>Data de fechamento:</label>
        <div class='input-group date' id='dataFechamento'>
          <input type='text' class="form-control" name="dataFechamento" >
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
      <div class="form-group">
        <label>Total de alunos matriculados:</label>
        <input type="text" name="totalAlunosMatriculados" class="form-control" value="{{ old('totalAlunosMatriculados', $percepcao->totalAlunosMatriculados) }}">
      </div>

      @if(isset($percepcao->id))
        <div class="form-group">
          <label>Libera consulta para membros especiais?</label>
          <select name="liberaConsultaMembrosEspeciais" class="form-control">
            <option value="">Selecione...</option>
            @foreach($percepcao::simNao() as $simNao)
              @if( old('liberaConsultaMembrosEspeciais') == '' )
                <option value="{{ $simNao }}" {{ ($percepcao->liberaConsultaMembrosEspeciais == $simNao) ? 'selected' : '' }}>{{ $simNao }}</option>
              @else
                <option value="{{ $simNao }}" {{ (old('liberaConsultaMembrosEspeciais') == $simNao) ? 'selected' : '' }}>{{ $simNao }}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Libera consulta docente?</label>
          <select name="liberaConsultaDocente" class="form-control">
            <option value="">Selecione...</option>
            @foreach($percepcao::simNao() as $simNao)
              @if( old('liberaConsultaDocente') == '' )
                <option value="{{ $simNao }}" {{ ($percepcao->liberaConsultaDocente == $simNao) ? 'selected' : '' }}>{{ $simNao }}</option>
              @else
                <option value="{{ $simNao }}" {{ (old('liberaConsultaDocente') == $simNao) ? 'selected' : '' }}>{{ $simNao }}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Libera consulta aluno?</label>
          <select name="liberaConsultaAluno" class="form-control">
            <option value="">Selecione...</option>
            @foreach($percepcao::simNao() as $simNao)
              @if( old('liberaConsultaAluno') == '' )
                <option value="{{ $simNao }}" {{ ($percepcao->liberaConsultaAluno == $simNao) ? 'selected' : '' }}>{{ $simNao }}</option>
              @else
                <option value="{{ $simNao }}" {{ (old('liberaConsultaAluno') == $simNao) ? 'selected' : '' }}>{{ $simNao }}</option>
              @endif
            @endforeach
          </select>
        </div>
      @endif

      @section('javascripts_bottom')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
        <script>
            $(function () {
              $('#dataAbertura').datetimepicker({
                locale: 'pt-br',
                format: 'DD/MM/YYYY HH:mm:ss',
                sideBySide: true
              });
              $('#dataFechamento').datetimepicker({
                locale: 'pt-br',
                format: 'DD/MM/YYYY HH:mm:ss',
                sideBySide: true,
                useCurrent: false //Important! See issue #1075
              });
              $("#dataAbertura").on("dp.change", function (e) {
                $('#dataFechamento').data("DateTimePicker").minDate(e.date);
              });
              $("#dataFechamento").on("dp.change", function (e) {
                $('#dataAbertura').data("DateTimePicker").maxDate(e.date);
              });
            });
        </script>
      @endsection

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
    </div>
  </form>
</div>
