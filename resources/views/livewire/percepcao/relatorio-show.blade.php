<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="col-sm-4">
        <x-form.wire-select
            model="percepcaoSelected"
            label="<span class='bold'>Selecione a percepção:</span>"
            :options="$this->options"
            >
            <option disabled value="">PERCEPÇÃO - SEMESTRE/ANO</option>
        </x-form.wire-select>
        @if (end($path) === 'disciplinas' && !empty($optionDisciplinas))
            <x-form.wire-select
                model="disciplinaSelected"
                label="<span class='bold'>Selecione a disciplina:</span>"
                :options="$this->optionDisciplinas"
                placeholder="Selecione a disciplina..."
                />
            @isset ($disciplina)
                @foreach ($percepcao->questaos()->get('grupos') as $idGrupo => $grupo)
                    @if ($grupo['modelo_repeticao'] === 'disciplinas')
                        <div class="pb-5">
                            <h4 class="pt-3">
                                {{ $this->getDetalheGrupo($idGrupo)['texto'] }}
                            </h4>
                            @if (isset($grupo['questoes']))
                                @foreach ($grupo['questoes'] as $idQuestao => $questao)
                                    @if ($this->getDetalheQuestao($idQuestao)['estatistica'])
                                        <div>
                                            @livewire('percepcao.grafico-show', ['percepcao' => $percepcao, 'disciplina' => $disciplina, 'grupo' => $grupo, 'questao' => $questao], key('disciplina-' . $percepcao->id . $grupo['id'] . $questao['id'] . time()))
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if (isset($grupo['grupos']))
                                @foreach ($grupo['grupos'] as $subIdGrupo => $subGrupo)
                                    <div>
                                        <h4 class="pt-5">
                                            {{ $this->getDetalheGrupo($subIdGrupo)['texto'] }}
                                        </h4>
                                        @if (isset($subGrupo['questoes']))
                                            @foreach ($subGrupo['questoes'] as $idQuestao => $questao)
                                                @if ($this->getDetalheQuestao($idQuestao)['estatistica'])
                                                    <div>
                                                        @livewire('percepcao.grafico-show', ['percepcao' => $percepcao, 'disciplina' => $disciplina, 'grupo' => $subGrupo, 'questao' => $questao], key('disciplina-' . $percepcao->id . $grupo['id'] . $questao['id'] . time()))
                                                    </div>
                                                @else
                                                    <div class="pl-3 pt-3">
                                                        <h5>
                                                            {{ $this->getDetalheQuestao($idQuestao)['campo']['text'] }}
                                                        </h5>
                                                    </div>
                                                    @foreach ($this->getRespostas($subIdGrupo, $questao['id'], $percepcao->id, $disciplina->id) as $idResposta => $resposta)
                                                        <div class="pl-6 pt-2">
                                                            <span class="bold">Resposta aluno {{ $idResposta + 1 }}:</span><br />
                                                            @if (!empty($resposta))
                                                                <span class="pl-3">{{ $resposta }}</span>
                                                            @else
                                                                <span class="pl-3">Nenhuma resposta enviada!</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                @endforeach
            @endisset
        @endif
        @if (end($path) === 'coordenadores' && !empty($optionCoordenadores))
            <x-form.wire-select
                model="coordenadorSelected"
                label="<span class='bold'>Selecione o coordenador:</span>"
                :options="$this->optionCoordenadores"
                placeholder="Selecione o coordenador..."
                />
            @isset ($coordenador)
                @foreach ($percepcao->questaos()->get('grupos') as $idGrupo => $grupo)
                    @if ($grupo['modelo_repeticao'] === 'coordenadores')
                        <div>
                            <h4 class="pt-3">
                                {{ $this->getDetalheGrupo($idGrupo)['texto'] }}
                            </h4>
                            @if (isset($grupo['questoes']))
                                @foreach ($grupo['questoes'] as $idQuestao => $questao)
                                    @if ($this->getDetalheQuestao($idQuestao)['estatistica'])
                                        <div>
                                            @livewire('percepcao.grafico-show', ['percepcao' => $percepcao, 'coordenador' => $coordenador, 'grupo' => $grupo, 'questao' => $questao], key('coordenador-' . $percepcao->id . $grupo['id'] . $questao['id'] . time()))
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if (isset($grupo['grupos']))
                                @foreach ($grupo['grupos'] as $subIdGrupo => $subGrupo)
                                    <div>
                                        <h4 class="pt-5">
                                            {{ $this->getDetalheGrupo($subIdGrupo)['texto'] }}
                                        </h4>
                                        @if (isset($subGrupo['questoes']))
                                            @foreach ($subGrupo['questoes'] as $idQuestao => $questao)
                                                @if ($this->getDetalheQuestao($idQuestao)['estatistica'])
                                                    <div>
                                                        @livewire('percepcao.grafico-show', ['percepcao' => $percepcao, 'coordenador' => $coordenador, 'grupo' => $subGrupo, 'questao' => $questao], key('coordenador-' . $percepcao->id . $grupo['id'] . $questao['id'] . time()))
                                                    </div>
                                                @else
                                                    <div class="pl-3 pt-3">
                                                        <h5>
                                                            {{ $this->getDetalheQuestao($idQuestao)['campo']['text'] }}
                                                        </h5>
                                                    </div>
                                                    @foreach ($this->getRespostas($subIdGrupo, $questao['id'], $percepcao->id, null, $coordenador->id) as $idResposta => $resposta)
                                                        <div class="pl-6 pt-2">
                                                            <span class="bold">Resposta aluno {{ $idResposta + 1 }}:</span><br />
                                                            @if (!empty($resposta))
                                                                <span class="pl-3">{{ $resposta }}</span>
                                                            @else
                                                                <span class="pl-3">Nenhuma resposta enviada!</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                @endforeach
            @endisset
        @endif
    </div>
</div>
