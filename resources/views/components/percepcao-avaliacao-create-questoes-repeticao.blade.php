@foreach ($grupo->questaos as $keyQuestao => $questao)
    @if ($questao->campo['type'] !== 'hidden')
        <div class="h6">
            {{ $questao->campo['text'] }}
        </div>
        @switch($questao->campo['type'])
            @case('radio')
                <x-form.wire-radio
                    :model="'avaliacaoQuesitos.' . $grupo->id . '.' . $grupo->modelo_repeticao . '.' .$key.'.' . $questao->id . '.value'"
                    :arrValue="$this->questaoClass->getCamposQuestao($questao->id)['keys']"
                    :arrText="$this->questaoClass->getCamposQuestao($questao->id)['values']"
                    style="margin-left: 40px; margin-top: 15px; margin-bottom: 15px;"
                    />
                @break
            @case('textarea')
                @if (!empty($questao->campo['maxlength']))
                    <x-form.wire-textarea
                        :model="'avaliacaoQuesitos.' . $grupo->id . '.' . $grupo->modelo_repeticao . '.' .$key.'.' . $questao->id . '.value'"
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
                        :model="'avaliacaoQuesitos.' . $grupo->id . '.' . $grupo->modelo_repeticao . '.' .$key.'.' . $questao->id . '.value'"
                        wireModifier=".defer"
                        rows="{{ $questao->campo['rows'] }}"
                        />
                @endif
                @break
        @endswitch
    @endif
@endforeach