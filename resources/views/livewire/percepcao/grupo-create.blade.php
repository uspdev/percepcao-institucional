<div class="container" style="max-width: 1000px">
  <h2 class="text-center font-weight-bold">Cadastro de grupo de quesitos</h2>
  <hr>
  <x-form.wire-input
      model="texto"
      label="Texto:"
      type="text"
      wireModifier=".defer"
    />
  <x-form.wire-select
      model="parent_id"
      :options="$optionGrupos"
      label="Grupo superior:"
      wireModifier=".defer"
    />
  <div class="form-group">
    <label>Ativo?</label>
    <x-form.wire-switch
        model="ativo"
        wireModifier=".defer"
      />
  </div>
  <x-form.wire-button
      class="btn btn-primary"
      label="Enviar"
      click="save"
      wireModifier=".prevent"
    />

    <h2 class="text-center font-weight-bold">Lista de grupos</h2>
    
    @livewire('percepcao.grupo-show', key(time()))
    <!-- Modal para exclusão -->
    <div wire:ignore.self class="modal fade" id="excluirModal" tabindex="-1" role="dialog" aria-labelledby="excluirModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="excluirModalLabel">Confirmar Exclusão</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                      <span aria-hidden="true close-btn">×</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Tem certeza que deseja excluir?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cancelar</button>
                  <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Sim, excluir</button>
              </div>
          </div>
      </div>
    </div>
    @once
      <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @endonce
</div>
