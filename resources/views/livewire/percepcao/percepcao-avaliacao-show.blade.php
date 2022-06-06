<div>
    @if (empty($statusPercepcao))
        <p>&nbsp;</p>
        <pre class="font-weight-bold" style='white-space: pre-wrap; font-size: 16px; text-align: center'>
            @if (isset($percepcao->settings['textoApresentacao']) && !empty($percepcao->settings['textoApresentacao']))
              {!! $percepcao->settings['textoApresentacao'] !!}
            @endif
        </pre>
        <p class="font-weight-bold" style='text-align: center'>
            @if ($percepcaoEnvio)
                @if (isset($percepcao->settings['textoAgradecimentoEnvioAvaliacao']) && !empty($percepcao->settings['textoAgradecimentoEnvioAvaliacao']))
                    <span class='text-success'>{!! $percepcao->settings['textoAgradecimentoEnvioAvaliacao'] !!}</span>
                @else
                    <span class='text-success'>Obrigado pela sua participação no processo de avaliação de disciplinas deste semestre.</span>
                @endif
            @else
              <a href='avaliar'>CLIQUE AQUI PARA INICIAR O PROCESSO DE AVALIAÇÃO DE DISCIPLINAS</a>
            @endif
        </p>
    @else
        <p>&nbsp;</p>
        <p class="font-weight-bold" style='text-align: center'>
            {{ $statusPercepcao }}
        </p>
    @endif
</div>
