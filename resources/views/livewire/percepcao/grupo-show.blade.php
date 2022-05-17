<x-alpine.grupo-sortable :useFallback="false" :canDelete="true">
    @if (count($grupos) > 0)
        @foreach ($grupos as $grupo)
            <div data-sortable-id="{{ $grupo->id }}" id="grupo-{{ $grupo->id }}" class="list-group-item nested-1">
                @if ($this->canDelete($grupo->id))
                    <span>
                        <x-icon.menu class="w-4 h-4 opacity-50 cursor-move icon-sortable handler" />
                    </span>
                @endif
                <span class="texto-sortable">
                    @if ($this->canDelete($grupo->id))
                        <x-alpine.text-inline-edit :value="$grupo->texto" :id="$grupo->id" />
                    @else
                        {{ $grupo->texto }}
                    @endif
                </span>
                @if (!$grupo->grupos->count() && $this->canDelete($grupo->id))
                    <span class="acoes-sortable">
                        <x-form.wire-button
                            class="btn btn-danger text-danger btn-icon"
                            class-icon="w-6 h-6"
                            click="getSelectedId({{ $grupo->id }}, 'delete')"
                            action="delete"
                            data-toggle="modal"
                            data-target="#excluirModal"
                            />
                    </span>
                @endif
                <div class="clear"></div>
                <x-subgrupo :childGrupos="$grupo" :principal="true" :subgrupo="1" :canDelete="$this->canDelete($grupo->id)" />
            </div>
        @endforeach
    @endif
</x-alpine.grupo-sortable>