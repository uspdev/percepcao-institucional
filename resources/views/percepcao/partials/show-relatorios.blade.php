<div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      Relatórios
    </h5>
  </div>
  <div class="card-body">
    <div>
      @if (!$percepcao->isFinalizado())
        Os relatórios estarão disponíveis depois que a Percepção estiver finalizada.
      @else
        por disciplina<br>
        por docente<br>
        por coordenador
    </div>
    @endif
  </div>
</div>
