@extends('layouts.app')

@section('content')
  @if (empty($statusPercepcao))
    <p class="font-weight-bold text-center">Percepção institucional - Avaliação <b>{{ $percepcao->ano }}/{{ $percepcao->semestre }}</b></p>

    <ul class="list-group text-center">
      <li class="list-group-item">
        Período: de <b>{{ $percepcao->dataDeAbertura->translatedFormat('d/m/Y \à\s H:i:s \(l\)') }}</b>
        à <b>{{ $percepcao->dataDeFechamento->translatedFormat('d/m/Y \à\s H:i:s \(l\)') }}</b>
      </li>
    </ul>
    <p class="font-weight-bold text-center mt-3">
      {!! nl2br($percepcao->settings()->get('msgInicial')) !!}
    </p>
    <p class="font-weight-bold" style='text-align: center'>
      @if ($percepcaoEnvio)
        <span class='text-success'>Obrigado pela sua participação no processo de avaliação de disciplinas deste
          semestre.</span>
      @else
        <a href="avaliar" class="btn btn-primary">INICIAR AVALIAÇÃO</a>
      @endif
    </p>
  @else
    <p>&nbsp;</p>
    <p class="font-weight-bold" style='text-align: center'>
      {{ $statusPercepcao }}
    </p>
  @endif
@endsection
