@foreach ($grupo['questoes'] as $idQuestao => $questao)
    @if ($this->getDetalheQuestao($idQuestao)['campo']['type'] !== 'hidden')
        <div class="h6">
            {!! $this->getDetalheQuestao($idQuestao)['campo']['text'] !!}
        </div>

        @switch($this->getDetalheQuestao($idQuestao)['campo']['type'])

            @case('radio')
                <x-form.wire-radio
                    :model="'avaliacaoQuesitos.' . $grupo['id'] . '.' . $this->getDetalheGrupo($grupo['id'])['modelo_repeticao'] . '.' .$key.'.' . $idQuestao . '.value'"
                    :arrValue="$this->questaoClass->getCamposQuestao($idQuestao)['keys']"
                    :arrText="$this->questaoClass->getCamposQuestao($idQuestao)['values']"
                    {{-- style="margin-left: 40px; margin-top: 15px; margin-bottom: 15px;" --}}
                    />
                @break

            @case('textarea')
                @if (!empty($this->getDetalheQuestao($idQuestao)['campo']['maxlength']))
                    <x-form.wire-textarea
                        :model="'avaliacaoQuesitos.' . $grupo['id'] . '.' . $this->getDetalheGrupo($grupo['id'])['modelo_repeticao'] . '.' .$key.'.' . $idQuestao . '.value'"
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
                        :model="'avaliacaoQuesitos.' . $grupo['id'] . '.' . $this->getDetalheGrupo($grupo['id'])['modelo_repeticao'] . '.' .$key.'.' . $idQuestao . '.value'"
                        wireModifier=".defer"
                        rows="{{ $this->getDetalheQuestao($idQuestao)['campo']['rows'] }}"
                        />
                @endif
                @break

        @endswitch
    @endif
@endforeach