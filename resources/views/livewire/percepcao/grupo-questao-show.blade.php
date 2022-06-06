<div>
    @if ($grupoQuestaos->count())
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="h5 mt-4 mb-4">
                Questões adicionadas
            </div>
            <div id="sortable-questao-{{ $grupo->id }}" class="list-group-questao nested-sortable-questao col-sm-9"
                x-data="{}"
                x-init="Sortable.create($el, {
                    group: 'nested-questao-{{ $grupo->id }}',
                    animation: 150,
                    handle: '.handler-questao',
                    onSort: function (e) {
                        function serialize(sortable) {
                            var serialized = [];
                            var children = [].slice.call(sortable.children);
                            for (var i in children) {
                                var nested = children[i].querySelector('.nested-sortable-questao');
                                serialized.push({
                                    id: children[i].dataset['sortableId']
                                });
                            }
                            return serialized
                        }
                        const root = document.getElementById('sortable-questao-{{ $grupo->id }}');
                        @this.updateOrdemQuestao(serialize(root), {{ $grupo->id }});
                    }
                })"
            >
                @foreach ($grupoQuestaos as $questao)
                    <div data-sortable-id="{{ $questao->id }}" class="card shadow-sm mb-2" id="questao-{{ $questao->id }}">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <div>
                                    <x-icon.menu class="w-4 h-4 opacity-50 cursor-move handler-questao" />
                                </div>
                                <div class="h6 mt-2">
                                    {{ $questao->campo['text'] }}
                                </div>
                                @if ($this->canDelete())
                                    <div class="justify-content-end">
                                        <x-form.wire-button
                                            class="btn btn-danger text-danger btn-icon"
                                            class-icon="w-6 h-6"
                                            click="getSelectedId({{ $questao->id }}, 'questao', {{ $grupo->id }}, {{ $grupo->parent_id }})"
                                            action="delete"
                                            data-toggle="modal"
                                            data-target="#excluirModal"
                                            />
                                    </div>
                                @else
                                    <div>&nbsp;</div>
                                @endif
                            </div>
                            <div class="d-flex flex-row justify-content-center align-items-center">
                                @switch($questao->campo['type'])
                                    @case('radio')
                                        <div>
                                            <x-form.wire-radio
                                                model="{{ $questao->id }}"
                                                :arrValue="$questaoClass->getCamposQuestao($questao->id)['keys']"
                                                :arrText="$questaoClass->getCamposQuestao($questao->id)['values']"
                                                style="margin-left: 40px; margin-top: 15px; margin-bottom: 15px;"
                                                wireModifier=".defer"
                                                disabled="true"
                                                />
                                        </div>
                                        @break
                                    @case('textarea')
                                        <x-form.wire-textarea
                                            model="{{ $questao->id }}"
                                            wireModifier=".defer"
                                            rows="{{ $questao->campo['rows'] }}" maxlength="{{ $questao->campo['maxlength'] }}" id="content"
                                            disabled
                                            />
                                        @break
                                    @case('hidden')
                                        <span>Modelo: {{ $questao->campo['model']}}</span>
                                        @break
                                    @default

                                @endswitch
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="d-flex flex-column justify-content-center align-items-center pt-2" x-data="handler()" x-cloak>
        <div x-show="openAddQuestao">
            <section class="card shadow-sm mb-2" id="section4" >
                <div class="card-body">
                    <div class="sectionBody">
                        <div class="card-title">
                            <div class="bold">
                                <h2>Adicione a questão</h2>
                            </div>
                        </div>
                        <hr/>
                        <div class="card-text questionList">
                            @foreach ($questaos as $questao)
                                <div x-data="{ checkedQuestao{{ $questao->id }}: '' }" id="questao-{{ $questao->id }}-{{ $loop->index }}" class="card shadow-sm mb-2">
                                    <div class="card-body" x-bind:style="checkedQuestao{{ $questao->id }} ? `background-color: #ececf6` : ''">
                                        <x-form.wire-checkbox
                                            model="questao.{{ $questao->id }}"
                                            label="{{ $this->getTituloQuestao($questao->id) }}"
                                            classInput="questaoCheckbox"
                                            data-questao-id="{{ $questao->id }}"
                                            x-model="checkedQuestao{{ $questao->id }}"
                                            wireModifier=".defer"
                                            />
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center align-items-center p-2">
                                <x-form.wire-button
                                    class="btn btn-dark text-dark btn-icon"
                                    class-icon="w-8 h-8"
                                    click=""
                                    label="Salvar questão"
                                    action="save"
                                    @click="$wire.saveSelectedQuestoes(addCheckedTipos('questao'), {{ $grupo->id }})"
                                    />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div>
            <x-form.wire-button
                class="btn btn-dark text-dark btn-icon"
                class-icon="w-8 h-8"
                click=""
                label="Adicionar questão"
                action="add"
                @click="openAddQuestao = true"
                />
        </div>
    </div>
</div>
