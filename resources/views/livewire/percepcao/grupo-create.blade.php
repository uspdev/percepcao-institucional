<div class="container" style="max-width: 1000px" x-cloak
    x-data="{
        openModeloRepeticao: false,
        repeticao: ''
    }">
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
        <label>Terá repetição?</label>
        <x-form.wire-switch
            model="repeticao"
            wireModifier=".defer"
            x-model="repeticao"
            @change="
                console.log(repeticao);
                if (repeticao) {
                    openModeloRepeticao = true;
                } else {
                    openModeloRepeticao = false;
                }
            "
            />
    </div>
    <div x-show="openModeloRepeticao === true">
        <x-form.wire-select
            model="modelo_repeticao"
            :options="[
                '' => 'Selecione um modelo...',
                'disciplinas' => 'Disciplinas',
                'coordenadores' => 'Coordenadores',
            ]"
            label="Modelo da repetição:"
            wireModifier=".defer"
            />
    </div>
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

    <div>
        @livewire('percepcao.grupo-show', key(time()))
    </div>
    {{-- Modal para exclusão --}}
    <x-modal.delete />
</div>
