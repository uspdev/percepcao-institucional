@extends('layouts.app')

@section('content')
  {{ $disciplina['nomabvset'] }}/{{ $disciplina['sglund'] }}<br>
  {{ $disciplina['coddis'] }} - {{ $disciplina->nomdis }}<br>
  Professor: {{ $disciplina->nompes }}<br>
  <br>

  {{-- @dd($questoes[9],$questoes[10]) --}}

  @foreach ($questoes as $questao)
    {{ $questao->campo['text'] }} <span class="badge badge-primary badge-pill">{{ $questao->totalRespostas }}</span><br>
    <div class="ml-3">

      @if ($questao->estatistica)
        <img height="150px" src="data:image/png;base64, {{ base64_encode($questao->bargraph) }}" alt="bargraph"><br>
      @endif

      @if (!$questao->estatistica)
        @foreach ($questao->respostasTextuais as $key => $resposta)
          {{ $key + 1 }}: {{ $resposta }}<br>
        @endforeach
      @endif
    </div>

    <br>
  @endforeach
@endsection
