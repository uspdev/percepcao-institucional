<div>
  @if(empty($statusPercepcao))
    <p>&nbsp;</p>
    <pre class="font-weight-bold" style='white-space: pre-wrap; font-size: 16px; text-align: center'>
      No período do dia {{ $percepcao->dataDeAbertura->translatedFormat('d/m/Y \à\s H:i:s \(l\)') }} ao dia {{ $percepcao->dataDeFechamento->translatedFormat('d/m/Y \à\s H:i:s \(l\)') }}, estará aberto o Processo de Avaliação de Disciplinas.
      A participação de todos os discentes é muito importante e permitirá o levantamento de informações que levarão a um processo contínuo de melhoria da qualidade de ensino na EEL-USP.
      Não deixem de responder o Questionário preparado especialmente para vocês, alunos. Além de perguntas direcionadas, existem campos de texto que podem ser usados livremente.
      Todas as questões devem ser respondidas antes de submeter o Questionário, mas não serão necessários mais que 10-15 minutos.

      A Comissão de Avaliação de Disciplinas (CAD).
    </pre>
    <p class="font-weight-bold" style='text-align: center'>
      @if($percepcaoEnvio)
        <span class='text-success'>Obrigado pela sua participação no processo de avaliação de disciplinas deste semestre.</span>
      @else
        <a href='/percepcao-institucional/avaliar'>CLIQUE AQUI PARA INICIAR O PROCESSO DE AVALIAÇÃO DE DISCIPLINAS</a>
      @endif
    </p>
  @else
    <p>&nbsp;</p>
    <p class="font-weight-bold" style='text-align: center'>
      {{ $statusPercepcao }}
    </p>
  @endif
</div>
