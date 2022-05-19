<div class="container" style="max-width: 1000px">
    @if ($this->percepcao)
        @if (!$this->statusPercepcao)
            <h3 class="text-center font-weight-bold">
                Avaliação <span>{{ $percepcao->ano }}</span>/<span>{{ $percepcao->semestre }}@if($path === "avaliar/preview/$percepcao->id") - PREVIEW<small class="align-top"> (<a href="gestao-sistema/percepcao">sair</a>)</small> @endif</span>
            </h3>
            <hr>
            <div class="text-danger font-weight-bold mb-3">
                O presente questionário será utilizado na EEL-USP para melhoria da qualidade de ensino. As identidades serão
                preservadas com total sigilo. (mudar para texto configurável)
            </div>
            @if ($percepcao->grupos->count())
                @foreach ($percepcao->grupos as $key => $grupo)
                    <div class="text-center my-3 bold">
                        {{ $key + 1 }}. {{ $grupo->texto }}
                    </div>
                    @if ($grupo->repeticao)
                        @if ($grupo->modelo_repeticao === 'disciplinas')
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

                                        <x-percepcao-avaliacao-create-questoes-repeticao :grupo="$grupo" :key="$keyDisciplina" />

                                        <br />
                                        @if ($grupo->grupos->count())
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
                        @if ($grupo->modelo_repeticao === 'coordenadores')
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
                                        @if ($grupo->grupos->count())
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
                        @foreach ($grupo->questaos as $keyQuestao => $questao)
                            <div class="h6">
                                {{ $questao->campo['text'] }}:
                            </div>
                            @switch($questao->campo['type'])
                                @case('radio')
                                    <x-form.wire-radio
                                        :model="'avaliacaoQuesitos.' . $grupo->id . '.' . $questao->id . '.value'"
                                        :arrValue="$this->questaoClass->getCamposQuestao($questao->id)['keys']"
                                        :arrText="$this->questaoClass->getCamposQuestao($questao->id)['values']"
                                        style="margin-left: 40px; margin-top: 15px; margin-bottom: 15px;"
                                        />
                                    @break
                                @case('textarea')
                                    @if (!empty($questao->campo['maxlength']))
                                        <x-form.wire-textarea
                                            :model="'avaliacaoQuesitos.' . $grupo->id . '.' . $questao->id . '.value'"
                                            wireModifier=".defer"
                                            xData='{
                                                    content: "",
                                                    limit: $el.dataset.limit,
                                                    get remaining() {
                                                        return this.limit - this.content.length
                                                    }
                                                }'
                                            dataLimit="{{ $questao->campo['maxlength'] }}"
                                            append="<p id='remaining'>
                                                        <span class='small'>Conteúdo limitado a <span x-text='limit'></span> caracteres, restando: <span class='font-weight-bold' x-text='remaining'></span><span>
                                                    </p>"
                                            rows="{{ $questao->campo['rows'] }}" maxlength="{{ $questao->campo['maxlength'] }}" id="content" x-model="content"
                                            />
                                    @else
                                        <x-form.wire-textarea
                                            :model="'avaliacaoQuesitos.' . $grupo->id . '.' . $questao->id . '.value'"
                                            wireModifier=".defer"
                                            rows="{{ $questao->campo['rows'] }}"
                                            />
                                    @endif
                                    @break
                            @endswitch
                        @endforeach
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
                    <a href="gestao-sistema/percepcao" class="btn btn-primary">Voltar</a>
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
