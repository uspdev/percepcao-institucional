<div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      Textos
    </h5>
  </div>
  <div class="card-body">
    <div>
        <div class="font-weight-bold">Texto da tela de apresentação</div>
        <div class="ml-2">{!! nl2br($percepcao->settings['textoApresentacao']) !!}</div>
    </div>
    <div class="mt-3">
        <div class="font-weight-bold">Texto do formulário de avaliação</div>
        <div class="ml-2">{!! nl2br($percepcao->settings['textoFormularioAvaliacao']) !!}</div>
    </div>
    <div class="mt-3">
        <div class="font-weight-bold">Mensagem de agradecimento ao enviar uma avaliação</div>
        <div class="ml-2">{!! nl2br($percepcao->settings['textoAgradecimentoEnvioAvaliacao']) !!}</div>
    </div>
  </div>
</div>
