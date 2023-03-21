<div class="alert alert-info text-center">
  <p>Não existe Percepção Institucional ativa no momento!</p>
  @can('verifica-docente')
    <p>
      <a href="{{ route('percepcao.consulta.disciplinas') }}">Consultar percepções anteriores</a>
    </p>
  @endcan
</div>
