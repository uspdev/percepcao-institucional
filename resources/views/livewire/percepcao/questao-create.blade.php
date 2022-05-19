<div class="container" id="cadastro-questao">
    <h2 class="text-center font-weight-bold">Cadastro de questões</h2>
    <hr>
    <div x-data="handler()" x-cloak>
        <x-form.wire-input
            model="campos.text"
            label="Título da questão:"
            type="text"
            wireModifier=".defer"
            />
        <x-form.wire-select
            model="campos.type"
            :options="[
                '' => 'Selecione o tipo de campo...',
                'text' => 'Texto',
                'textarea' => 'Textarea',
                'radio' => 'Radio',
            ]"
            label="Tipo de campo:"
            wireModifier=".defer"
            x-on:change="
                selectedField = $event.target.value;
                if(selectedField === 'radio' && fields.length === 0) {
                    addNewOption();
                } else {
                    fields = [];
                }
            "
            />
        <div x-show="selectedField === 'textarea'">
            <div class="d-flex flex-row justify-content-center">
                <x-form.wire-input
                    model="campos.rows"
                    label="Linhas(rows):"
                    type="text"
                    class="p-1"
                    wireModifier=".defer"
                    />
                <x-form.wire-input
                    model="campos.cols"
                    label="Colunas(cols):"
                    type="text"
                    class="p-1"
                    wireModifier=".defer"
                    />
                <x-form.wire-input
                    model="campos.maxlength"
                    label="Máximo de caracteres(maxlength):"
                    type="text"
                    class="p-1"
                    wireModifier=".defer"
                    />
            </div>
        </div>
        <div x-show="selectedField === 'radio'">
            @foreach ($campos['options'] as $key => $campo)
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <x-form.wire-input
                        model="campos.options.{{ $key }}.value"
                        label="Valor"
                        type="text"
                        class="p-1 my-0"
                        placeholder="Ex.: Muito ruim"
                        wireModifier=".defer"
                        />
                    <x-form.wire-input
                        model="campos.options.{{ $key }}.key"
                        label="Chave"
                        type="text"
                        class="p-1 my-0"
                        placeholder="Ex.: 1"
                        wireModifier=".defer"
                        />
                    <x-form.wire-button
                        class="btn btn-danger text-danger btn-icon mt-4"
                        class-icon="w-6 h-6"
                        click="removeOption({{ $key }})"
                        action="delete"
                        />
                </div>
            @endforeach
        </div>
        <div class="text-center">
            <x-form.wire-button
                class="btn btn-dark text-dark btn-icon"
                class-icon="w-8 h-8"
                click="addOption"
                label="Adicionar opção"
                action="add"
                x-show="selectedField === 'radio'"
                />
        </div>
        <x-form.wire-input
            model="campos.class"
            label="Classes:"
            type="text"
            wireModifier=".defer"
            />
        <x-form.wire-input
            model="campos.rules"
            label="Regras:"
            type="text"
            help="Digite as regras no estilo Laravel. Ex.: required|min:1|max:10"
            wireModifier=".defer"
            />
        <div class="form-group">
            <label>Ativo?</label>
            <x-form.wire-switch
                model="ativo"
                wireModifier=".defer"
                />
        </div>
    </div>
    @if ($updating)
        <x-form.wire-button
            class="btn btn-danger"
            label="Cancelar"
            click="cancelUpdate"
            wireModifier=".prevent"
            />
        <x-form.wire-button
            class="btn btn-primary"
            label="Atualizar"
            click="save"
            wireModifier=".prevent"
            />
    @else
        <x-form.wire-button
            class="btn btn-primary"
            label="Enviar"
            click="save"
            wireModifier=".prevent"
            />
    @endif
    <div>
        @livewire('percepcao.questao-show', key(time()))
    </div>

    @section('javascripts_bottom')
        @parent
        <script>
            function handler() {
                return {
                    openAddQuestao: false,
                    selectedField: @entangle('selectedField'),
                    fields: [],

                    addNewOption() {
                        this.fields.push({id: new Date().getTime() + this.fields.length});
                    },
                    removeOption(field) {
                        this.fields.splice(this.fields.indexOf(field, 1));
                    },
                }
            }

            Livewire.on('gotoUpdate', section => {
                var addTop;
                if (section == 'cadastro-questao') {
                    addTop = 0;
                } else {
                    addTop = 300;
                }
                $('html, body').animate({
                    scrollTop: $('#' + section).offset().top +addTop
                }, 500, 'swing');
            });
        </script>
    @endsection
</div>
