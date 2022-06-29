<div class="container" style="max-width: 1000px">
    @if ($this->percepcao)
        @if (!$this->statusPercepcao)
            @if($this->preview)
                <h2 class="">
                    <a class="" href="gestao-sistema/percepcao">Percepções</a> 
                    <i class="fas fa-angle-right"></i> Percepção Institucional <i class="fas fa-angle-right"></i> Preview
                </h2>
                <hr />
            @endif
            <h3 class="text-center font-weight-bold">
                Avaliação <span>{{ $percepcao->ano }}</span>/<span>{{ $percepcao->semestre }}</span>
            </h3>
            <hr>
            @if (isset($percepcao->settings['textoFormularioAvaliacao']) && !empty($percepcao->settings['textoFormularioAvaliacao']))
                <div class="text-danger font-weight-bold mb-3">
                    {{ $percepcao->settings['textoFormularioAvaliacao'] }}
                </div>
            @endif
            @if ($percepcao->settings()->has('grupos'))
                @foreach ($percepcao->settings()->get('grupos') as $idGrupo => $grupo)
                    <div class="text-center my-3 bold">
                        {{ $grupo['ordem'] }}. {{ $grupo['texto'] }}
                    </div>
                    @if ($this->getDetalheGrupo($idGrupo)['repeticao'])
                        @if ($this->getDetalheGrupo($idGrupo)['modelo_repeticao'] === 'disciplinas')
                            @foreach ($dadosDisciplina as $keyDisciplina => $disciplina)
                                <fieldset class="border p-2"
                                    id="{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}">

                                    <legend class="w-auto h6 text-info" data-toggle="collapse"
                                        data-target="#collapse-{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}"
                                        aria-expanded="false"
                                        aria-controls="collapse-{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}"
                                        style="cursor: pointer;">
                                        {{ mb_strtoupper($disciplina['nomdis']) }}
                                        ({{ mb_strtoupper($disciplina['coddis']) }})
                                    </legend>

                                    <div id="collapse-{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}"
                                        class="collapse show form-group text-justify">
                                        <div class="h6">
                                            Ministrante:
                                            <span class="bold">
                                                {{ $disciplina['nompes'] }}
                                            </span>
                                        </div>

                                        <div class="h6 pb-3">
                                            Turma:
                                            <span class="bold">
                                                {{ $disciplina['codtur'] }} - {{ $disciplina['tiptur'] }}
                                            </span>
                                        </div>

                                        @if (isset($grupo['questoes']))
                                            <x-percepcao-avaliacao-create-questoes-repeticao :grupo="$grupo" :key="$keyDisciplina" />
                                        @endif

                                        <br />
                                        @if (isset($grupo['grupos']))
                                            <x-percepcao-avaliacao-create-subgrupo :childGrupos="$grupo" :key="$keyDisciplina" :dadosModelo="$disciplina" />
                                        @endif

                                    </div>
                                    <div id="collapse-{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}" class="collapse form-group text-justify">
                                        Clique no título para exibir
                                    </div>
                                </fieldset>
                                <br />
                            @endforeach
                        @endif
                        @if ($this->getDetalheGrupo($idGrupo)['modelo_repeticao'] === 'coordenadores')
                            @foreach ($dadosCoordenador as $keyCoordenador => $coordenador)
                                <fieldset class="border p-2"
                                    id="{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}">

                                    <legend class="w-auto h6 text-info" data-toggle="collapse"
                                        data-target="#collapse-{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}"
                                        aria-expanded="false"
                                        aria-controls="collapse-{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}"
                                        style="cursor: pointer;">
                                        CURSO: {{ mb_strtoupper($coordenador['nomcur']) }}
                                    </legend>

                                    <div id="collapse-{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}"
                                        class="collapse show form-group text-justify">
                                        <div class="h6 pb-3">
                                            Coordenador:
                                            <span class="bold">
                                                {{ $coordenador['nompes'] }}
                                            </span>
                                        </div>

                                        <x-percepcao-avaliacao-create-questoes-repeticao :grupo="$grupo" :key="$keyCoordenador" />

                                        <br />
                                        @if (isset($grupo['grupos']))
                                            <x-percepcao-avaliacao-create-subgrupo :childGrupos="$grupo" :key="$keyCoordenador" :dadosRepeticao="$coordenador" />
                                        @endif

                                    </div>
                                    <div id="collapse-{{ $disciplina['coddis'] }}-{{ $keyCoordenador }}" class="collapse form-group text-justify">
                                        Clique no título para exibir
                                    </div>
                                </fieldset>
                                <br />
                            @endforeach
                        @endif
                    @else
                        @if (isset($grupo['questoes']))
                            @foreach ($grupo['questoes'] as $idQuestao => $questao)
                                <div class="h6">
                                    {{ $this->getDetalheQuestao($idQuestao)['campo']['text'] }}:
                                </div>
                                @switch($this->getDetalheQuestao($idQuestao)['campo']['type'])
                                    @case('radio')
                                        <x-form.wire-radio
                                            :model="'avaliacaoQuesitos.' . $idGrupo . '.' . $idQuestao . '.value'"
                                            :arrValue="$this->questaoClass->getCamposQuestao($idQuestao)['keys']"
                                            :arrText="$this->questaoClass->getCamposQuestao($idQuestao)['values']"
                                            style="margin-left: 40px; margin-top: 15px; margin-bottom: 15px;"
                                            />
                                        @break
                                    @case('textarea')
                                        @if (!empty($this->getDetalheQuestao($idQuestao)['campo']['maxlength']))
                                            <x-form.wire-textarea
                                                :model="'avaliacaoQuesitos.' . $idGrupo . '.' . $idQuestao . '.value'"
                                                wireModifier=".defer"
                                                xData='{
                                                        content: "",
                                                        limit: $el.dataset.limit,
                                                        get remaining() {
                                                            return this.limit - this.content.length
                                                        }
                                                    }'
                                                dataLimit="{{ $this->getDetalheQuestao($idQuestao)['campo']['maxlength'] }}"
                                                append="<p id='remaining'>
                                                            <span class='small'>Conteúdo limitado a <span x-text='limit'></span> caracteres, restando: <span class='font-weight-bold' x-text='remaining'></span><span>
                                                        </p>"
                                                rows="{{ $this->getDetalheQuestao($idQuestao)['campo']['rows'] }}" maxlength="{{ $this->getDetalheQuestao($idQuestao)['campo']['maxlength'] }}" id="content" x-model="content"
                                                />
                                        @else
                                            <x-form.wire-textarea
                                                :model="'avaliacaoQuesitos.' . $idGrupo . '.' . $idQuestao . '.value'"
                                                wireModifier=".defer"
                                                rows="{{ $this->getDetalheQuestao($idQuestao)['campo']['rows'] }}"
                                                />
                                        @endif
                                        @break
                                @endswitch
                            @endforeach
                        @endif
                    @endif
                    <br />
                @endforeach

                @if ($errors->any())
                    @error('disciplina')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                @endif
                @if ($this->preview)
                    <a href="gestao-sistema/percepcao" class="btn btn-primary">Voltar para percepções</a>
                @else
                    <button wire:click.prevent='save' class="btn btn-primary">Enviar</button>
                @endif
            @endif
        @else
            <div class="font-weight-bold text-center mt-5">
                {!! $this->statusPercepcao !!}
            </div>
        @endif
    @else
        <div class="font-weight-bold text-center mt-5">
            Nenhuma Percepção Institucional foi encontrada para este ano/semestre.
        </div>
    @endif
</div>
