<div class="container" style="max-width: 1000px">
    <h2 class="text-center font-weight-bold">Cadastro de grupo de questões</h2>
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
    <x-modal.delete />
</div>
