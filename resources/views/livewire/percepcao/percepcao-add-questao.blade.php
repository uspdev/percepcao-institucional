<div class="container">
    <h2 class="text-center font-weight-bold">Percepção Institucional - Adicionar Questões</h2>
    <hr>
    <div class="d-flex justify-content-center align-items-center flex-column">
    <div>
            <label class="bold">Percepção Ano/Semestre:</label><span> {{ $percepcao->ano }}/{{ $percepcao->semestre }}</span>
        </div>
        <div>
            <label class="bold">Data de Abertura: </label><span> {{ $percepcao->dataDeAbertura->format('d/m/Y H:i') }}</span>
        </div>
        <div>
            <label class="bold">Data de Fechamento: </label><span> {{ $percepcao->dataDeFechamento->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    @if ($percepcao->grupos->count())
        @livewire('percepcao.grupo-percepcao-show', ['grupos' => $percepcao->grupos, 'percepcaoId' => $percepcao->id], key(time()))
    @endif
    <div class="d-flex flex-column justify-content-center align-items-center pt-2" x-data="handler()" x-cloak>
        <div x-show="openAddGrupo" class="col-sm-9">
            <section class="card shadow-sm mb-2" id="section4" >
                <div class="card-body">
                    <div class="sectionBody">
                        <div class="card-title">
                            <div class="bold">
                                <h2>Adicione o grupo</h2>
                            </div>
                        </div>
                        <hr/>
                        <div class="card-text questionList">
                            @if (count($grupos) > 0)
                                @foreach ($grupos as $grupo)
                                    <div x-data="{ checkedGrupo{{ $grupo->id }}: '' }" id="grupo-{{ $grupo->id }}-{{ $loop->index }}" class="card shadow-sm mb-2">
                                        <div class="card-body" x-bind:style="checkedGrupo{{ $grupo->id }} ? `background-color: #ececf6` : ''">
                                            <x-form.wire-checkbox
                                                model="grupoCheck.{{ $grupo->id }}"
                                                label="{{ $grupo->texto }}"
                                                classInput="grupoCheckbox"
                                                data-grupo-id="{{ $grupo->id }}"
                                                x-model="checkedGrupo{{ $grupo->id }}"
                                                wireModifier=".defer"
                                                />
                                            <x-list-subgrupo :childGrupos="$grupo" :principal="true" :subgrupo="5" />
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-center align-items-center p-2">
                                    <x-form.wire-button
                                        class="btn btn-dark text-dark btn-icon"
                                        class-icon="w-8 h-8"
                                        click=""
                                        label="Salvar grupo"
                                        action="save"
                                        @click="$wire.saveSelectedGrupos(addCheckedTipos('grupo'))"
                                        />
                                </div>
                            @endif
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
                label="Adicionar grupo"
                action="add"
                @click="openAddGrupo = true"
                />
        </div>
    </div>
    <div>
        <a href="gestao-sistema/percepcao">
            <x-form.wire-button
                class="btn btn-primary"
                class-icon="w-8 h-8"
                click=""
                label="Voltar"
                />
        </a>
    </div>

    <x-modal.delete />

    @section('javascripts_bottom')
        @parent
        <script>
            function handler() {
                return {
                    openAddGrupo: false,
                    openAddQuestao: false,
                    check: [],

                    addCheckedTipos(tipo) {
                        var check = [];
                        var tipoChecked = Array.from(document.querySelectorAll('.' + tipo + 'Checkbox:checked'));
                        tipoChecked.forEach(function(el) {
                            check.push({
                                id: el.dataset[tipo + 'Id']
                            });
                        });
                        return check;
                    },
                }
            }
        </script>
    @endsection
</div>
