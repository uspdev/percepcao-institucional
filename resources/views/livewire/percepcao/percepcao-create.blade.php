<div class="container">
    <x-form.wire-input
        model="ano"
        label="Ano:"
        type="text"
        wireModifier=".defer"
        />
    <x-form.wire-select
        model="semestre"
        :options="[1 => 1, 2 => 2]"
        label="Semestre:"
        wireModifier=".defer"
        placeholder="Selecione..."
        />
    <x-form.wire-datetimepicker
        model="dataDeAbertura"
        label="Data de abertura:"
        :endDate="true"
        modelEndDate="dataDeFechamento"
        labelEndDate="Data de fechamento:"
        dateTimeFormat="DD/MM/YYYY HH:mm:ss"
        />

    <x-form.wire-textarea
        model="settings.textoApresentacao"
        label="Texto da tela de apresentação da Percepção:"
        wireModifier=".defer"
        rows="4"
        />

    <x-form.wire-textarea
        model="settings.textoFormularioAvaliacao"
        label="Texto do formulário de avaliação:"
        wireModifier=".defer"
        rows="4"
        />

    <x-form.wire-textarea
        model="settings.textoAgradecimentoEnvioAvaliacao"
        label="Mensagem de agradecimento ao enviar uma avaliação:"
        wireModifier=".defer"
        rows="4"
        />

    @if($updateId)
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
    @endif

    <div class="modal-footer">
        <x-form.wire-button
            class="btn btn-secondary close-btn"
            label="Cancelar"
            data-dismiss="modal"
            />
        <x-form.wire-button
            class="btn btn-primary"
            label="Enviar"
            click="save"
            wireModifier=".prevent"
            />
    </div>
</div>
