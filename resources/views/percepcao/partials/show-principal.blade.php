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
