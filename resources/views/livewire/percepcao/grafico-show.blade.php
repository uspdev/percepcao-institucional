<div>
  <div class="pl-3 pt-3 h5">
    {!! $questao['campo']['text'] !!}
  </div>
  <div class="pl-6 pt-3">
    <div>
      <span class="bold">Resultado médio:</span>
      @if (isset($disciplina))
        {{ $this->getRespostas($grupo['id'], $questao['id'], $percepcao->id, $disciplina->id)['media'] }}
      @endif
      @if (isset($coordenador))
        {{ $this->getRespostas($grupo['id'], $questao['id'], $percepcao->id, null, $coordenador->id)['media'] }}
      @endif
    </div>
    <div>
      @if (isset($disciplina))
        <span class="bold">Total de respostas:</span>
        {{ $this->getRespostas($grupo['id'], $questao['id'], $percepcao->id, $disciplina->id)['totalDeRespostas'] }}
      @endif
      @if (isset($coordenador))
        <span class="bold">Total de respostas:</span>
        {{ $this->getRespostas($grupo['id'], $questao['id'], $percepcao->id, null, $coordenador->id)['totalDeRespostas'] }}
      @endif
    </div>
  </div>
  @include('livewire.percepcao.partials.pie-chart')

</div>
