<x-alpine.grupo-sortable :useFallback="false" :canDelete="true">
    @foreach ($grupos as $grupo)
        <div data-sortable-id="{{ $grupo->id }}" id="grupo-{{ $grupo->id }}" class="list-group-item nested-1">
            <span>
                @if ($percepcao && $percepcao->isFuturo())
                    <x-icon.menu class="w-4 h-4 opacity-50 cursor-move icon-sortable handler" />
                @endif
            </span>
            <span class="texto-sortable">
                {{ $grupo->texto }}
            </span>
            @if ($percepcao && $percepcao->isFuturo())
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

            <div>
                @livewire('percepcao.grupo-questao-show', ['grupo' => $grupo, 'percepcaoId' => $percepcaoId], key(time()))
            </div>

            <x-grupo-percepcao-subgrupo :childGrupos="$grupo" :principal="true" :subgrupo="1" :percepcaoId="$percepcaoId" />
        </div>
    @endforeach
</x-alpine.grupo-sortable>