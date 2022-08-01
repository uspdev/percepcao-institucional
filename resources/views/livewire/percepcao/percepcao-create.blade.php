<div id="percepcao-create" class="container">
    <h2 class="text-center font-weight-bold">{{ $titulo }} de percepção</h2>
    <hr>
    <div class="row form-group">
        <x-form.wire-input
        model="settings.nome"
        label="Nome:"
        type="text"
        wireModifier=".defer"
        class="col-sm"
        />
        <x-form.wire-input
            model="ano"
            label="Ano:"
            type="text"
            wireModifier=".defer"
            class="col-sm"
            />
        <x-form.wire-select
            model="semestre"
            :options="[1 => 1, 2 => 2]"
            label="Semestre:"
            wireModifier=".defer"
            placeholder="Selecione..."
            class="col-sm"
            />
    </div>
    <div class="row form-group">
        <x-form.wire-datetimepicker
            model="dataDeAbertura"
            label="Data de abertura:"
            :endDate="true"
            modelEndDate="dataDeFechamento"
            labelEndDate="Data de fechamento:"
            dateTimeFormat="DD/MM/YYYY HH:mm:ss"
            class="col-sm"
            />
    </div>

    <div class="row form-group">
        <x-form.wire-textarea
            model="settings.textoApresentacao"
            label="Texto da tela de apresentação:"
            wireModifier=".defer"
            rows="4"
            class="col-sm"
        />
    </div>
    <div class="row form-group">
        <x-form.wire-textarea
            model="settings.textoFormularioAvaliacao"
            label="Texto do formulário de avaliação:"
            wireModifier=".defer"
            rows="4"
            class="col-sm"
            />
    </div>

    <x-form.wire-textarea
        model="settings.textoAgradecimentoEnvioAvaliacao"
        label="Mensagem de agradecimento ao enviar uma avaliação:"
        wireModifier=".defer"
        rows="4"
        />

    {{-- @if($updateId)
        <div class="form-group">
            <label>Libera consulta para membros especiais?</label>
            <x-form.wire-switch
                model="liberaConsultaMembrosEspeciais"
                wireModifier=".defer"
                />
        </div>
        <div class="form-group">
            <label>Libera consulta docente?</label>
            <x-form.wire-switch
                model="liberaConsultaDocente"
                wireModifier=".defer"
                />
        </div>
        <div class="form-group">
            <label>Libera consulta aluno?</label>
            <x-form.wire-switch
                model="liberaConsultaAluno"
                wireModifier=".defer"
                />
        </div>
    @endif --}}

    <div class="">
        <x-form.wire-button
            class="btn btn-secondary"
            label="Cancelar"
            click="cancelAction"
            />
        <x-form.wire-button
            class="btn btn-primary"
            label="Enviar"
            click="save"
            wireModifier=".prevent"
            />
    </div>
</div>
