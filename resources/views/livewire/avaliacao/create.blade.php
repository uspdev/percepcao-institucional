<div class="container" style="max-width: 1000px">
    @if ($this->percepcao)
        @if (!$this->statusPercepcao)

            @if($this->preview)
                <h2 class="">
                    <a class="" href="{{ route('percepcao.show', $percepcao) }}">
                        {{ $percepcao->settings['nome'] }} ({{ $percepcao->ano }}/{{ $percepcao->semestre }})
                    </a>
                    <i class="fas fa-angle-right"></i> Preview
                </h2>
                <hr />
            @endif
            
            <h3 class="text-center font-weight-bold">
                Avaliação {{ $percepcao->ano }}/{{ $percepcao->semestre }}
            </h3>
            <hr>

            <div class="text-danger font-weight-bold mb-3">
                {{ $percepcao->settings['textoFormularioAvaliacao'] }}
            </div>

            @if ($percepcao->questaos()->has('grupos'))
                @foreach ($percepcao->questaos()->get('grupos') as $idGrupo => $grupo)
                    <div class="text-center my-3 bold">
                        {{ $grupo['ordem'] }}. {{ $grupo['texto'] }}
                    </div>
                    @if ($this->getDetalheGrupo($idGrupo)['repeticao'])

                        @if ($this->getDetalheGrupo($idGrupo)['modelo_repeticao'] === 'disciplinas')
                            @include('livewire.avaliacao.partials.modelo-repeticao-disciplinas')
                        @endif

                        @if ($this->getDetalheGrupo($idGrupo)['modelo_repeticao'] === 'coordenadores')
                            @include('livewire.avaliacao.partials.modelo-repeticao-coordenadores')
                        @endif

                    @else
                        @if (isset($grupo['questoes']))
                            @include('livewire.avaliacao.partials.grupo-questoes')
                        @endif
                    @endif

                @endforeach

                @if ($errors->any())
                    @error('disciplina')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                @endif

                @if ($this->preview)
                    <a href="{{ route('percepcaos.index') }}" class="btn btn-primary">Voltar para percepções</a>
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
