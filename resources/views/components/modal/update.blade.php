<div wire:ignore.self class="modal fade" id="{{ $idModal }}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="percepcaoModalLabel">{{ $tituloModal}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true close-btn">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @livewire($formModal, ['updating' => true])
      </div>
    </div>
  </div>
</div>