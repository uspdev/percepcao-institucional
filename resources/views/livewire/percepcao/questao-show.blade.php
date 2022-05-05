<div class="d-flex flex-column justify-content-center align-items-center mt-5">
    <div class="h5 mt-2 mb-4">
        Questões cadastradas
    </div>
    @foreach ($questaos as $questao)
        <div class="card shadow-sm col-sm-9 mb-2" id="questao-{{ $questao->id }}">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <div class="h6 mt-2">
                        <label for="" class="bold">Título:</label>
                        {{ $questao->campo['text'] }}
                    </div>
                    <div class="justify-content-end">
                        <x-form.wire-button
                            class="btn btn-primary text-primary btn-icon"
                            class-icon="w-6 h-6"
                            click="getUpdateId({{ $questao->id }})"
                            action="update"
                            />
                        <x-form.wire-button
                            class="btn btn-info text-info btn-icon"
                            class-icon="w-6 h-6"
                            click="copyQuestao({{ $questao->id }})"
                            action="copy"
                            />
                        @if (!$this->hasGrupo($questao->id))
                            <x-form.wire-button
                                class="btn btn-danger text-danger btn-icon"
                                class-icon="w-6 h-6"
                                click="getSelectedId({{ $questao->id }}, 'questao')"
                                action="delete"
                                data-toggle="modal"
                                data-target="#excluirModal"
                                />
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column justify-content-start align-items-start">
                    <div>
                        <label for="" class="bold">Tipo:</label>
                        {{ $questao->campo['type'] }}
                    </div>
                    @if(!empty($questao->campo['rows']))
                        <div>
                            <label for="" class="bold">Linhas(rows):</label>
                            {{ $questao->campo['rows'] }}
                        </div>
                    @endif
                    @if(!empty($questao->campo['cols']))
                        <div>
                            <label for="" class="bold">Colunas(cols):</label>
                            {{ $questao->campo['cols'] }}
                        </div>
                    @endif
                    @if(!empty($questao->campo['maxlength']))
                        <div>
                            <label for="" class="bold">Máximo de caracteres(maxlength):</label>
                            {{ $questao->campo['maxlength'] }}
                        </div>
                    @endif
                    @if($questao->campo['options'] != "")
                        @foreach ($questao->campo['options'] as $key => $option)
                            <div class="d-flex flex-row justify-content-start align-items-start">
                                @isset($option['key'])
                                    <div class="pl-4">
                                        <label for="" class="bold">Chave(key):</label>
                                        {{ $option['key'] ?? '' }}
                                    </div>
                                @endisset
                                @isset($option['value'])
                                    <div class="pl-4">
                                        <label for="" class="bold">valor(value):</label>
                                        {{ $option['value'] ?? '' }}
                                    </div>
                                @endisset
                            </div>
                        @endforeach
                    @endif
                    @if (!empty($questao->campo['model']))
                        <div>
                            <label for="" class="bold">Modelo:</label>
                            {{ $questao->campo['model'] }}
                        </div>
                    @endif
                    @if ($questao->campo['type'] === 'hidden')
                        <div>
                            <label for="" class="bold">Exibir texto?</label>
                            @if (isset($questao->campo['exibirTexto']) && $questao->campo['exibirTexto'])
                                Sim
                            @else
                                Não
                            @endif
                        </div>
                    @endif
                    @if (!empty($questao->campo['class']))
                        <div>
                            <label for="" class="bold">Classes:</label>
                            {{ $questao->campo['class'] }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    <x-modal.delete />
</div>