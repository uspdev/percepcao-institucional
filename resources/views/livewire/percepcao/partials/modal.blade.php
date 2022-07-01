<div wire:ignore.self class="modal fade" id="percepcaoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="percepcaoModalLabel">Cadastrar/editar Percepção Institucional</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true close-btn">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @livewire('percepcao.percepcao-create')
      </div>
    </div>
  </div>
</div>
