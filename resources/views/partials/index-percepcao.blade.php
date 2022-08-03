<h3 class="font-weight-bold text-center">
  Avaliação {{ $percepcao->ano }}/{{ $percepcao->semestre }}
</h3>

<div class="alert alert-info text-center">
  {!! nl2br($percepcao->settings['textoApresentacao']) !!}
  <p class="mt-3">
    Período: de <b>{{ $percepcao->dataDeAbertura->translatedFormat('d/m/Y - H:i:s \(l\)') }}</b>
    à <b>{{ $percepcao->dataDeFechamento->translatedFormat('d/m/Y - H:i:s \(l\)') }}</b>
  </p>
</div>

@if ($percepcao->isPreview())
  <div class='alert alert-success text-center'>
    Em breve a avaliação estará disponível.
  </div>
@endif

@if ($percepcao->isPosview())
  <div class='alert alert-warning text-center'>
    O período de avaliação já está encerrado.<br />
    Contamos com você na próxima percepção.
  </div>
@endif

@if ($percepcao->isAberto())
  @include('partials.index-aberto')
@endif
