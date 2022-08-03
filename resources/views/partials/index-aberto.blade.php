@if (Gate::check('user'))
  @if ($percepcao->isRespondido())
    @if (!(Session::has('alert-info') && Session::get('alert-info') == $percepcao->settings['textoAgradecimentoEnvioAvaliacao']
    ))
      {{-- se acabou de responder ao questionário vamos ocultar mensagem --}}
      <p class='alert alert-success text-center'>
        Você já enviou uma Percepção Institucional para este ano/semestre. <br />
        Obrigado, e contamos com você na próxima percepção.
      </p>
    @endif
    {{-- mas vamos colocar o botão de logout --}}
    @include('partials.logout-btn')
  @else
    @if ($percepcao->listarDisciplinasAluno() == [])
      {{-- nao respondeu e não cursou disciplinas --}}
      <p class='alert alert-warning text-center'>
        Você não cursou disciplinas neste ano/semestre. <br />
        Contamos com você na próxima percepção.
      </p>
      @include('partials.logout-btn')
    @else
      {{-- nao respondeu e cursou disciplinas - vai responder --}}
      <p class="text-center">
        <a href="avaliar" class="btn btn-primary">INICIAR AVALIAÇÃO</a>
      </p>
    @endif
  @endif
@else
  <p class="text-center">
    {{-- nao fez logina inda --}}
    <a href="avaliar" class="btn btn-outline-primary">Faça login para inciar</a>
  </p>
@endif
