<x-alpine.grupo-sortable :useFallback="false" :canDelete="true">
    @if (count($grupos) > 0)
        @foreach ($grupos as $grupo)
            <div data-sortable-id="{{ $grupo->id }}" id="grupo-{{ $grupo->id }}" class="list-group-item nested-1">
                <span>
                    <x-icon.menu class="w-4 h-4 opacity-50 cursor-move icon-sortable handler" />
                </span>
                <span class="texto-sortable">
                    {{ $grupo->texto }}
                </span>
                @if ($this->canDelete())
                    <span class="acoes-sortable">
                        <x-form.wire-button
                            class="btn btn-danger text-danger btn-icon"
                            class-icon="w-6 h-6"
                            click="getSelectedId({{ $grupo->id }}, 'grupo')"
                            action="delete"
                            data-toggle="modal"
                            data-target="#excluirModal"
                            />
                    </span>
                @endif
                <div class="clear"></div>

                @livewire('percepcao.grupo-questao-show', ['grupo' => $grupo, 'percepcaoId' => $percepcaoId], key(time()))

                <x-grupo-percepcao-subgrupo :childGrupos="$grupo" :principal="true" :subgrupo="1" :percepcaoId="$percepcaoId" />
            </div>
        @endforeach
    @endif
</x-alpine.grupo-sortable>