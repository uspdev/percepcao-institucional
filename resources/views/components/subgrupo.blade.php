@if ($principal === false)
    <div data-sortable-id="{{ $childGrupos->id }}" id="grupo-{{ $childGrupos->id }}" class="list-group-item nested-{{ $subgrupo }}">
        @if ($canDelete)
            <span>
                <x-icon.menu class="w-4 h-4 opacity-50 cursor-move icon-sortable handler" />
            </span>
        @endif
        <span class="texto-sortable">
            @if ($canDelete)
                <x-alpine.text-inline-edit :value="$childGrupos->texto" :id="$childGrupos->id" />
            @else
                {{ $childGrupos->texto }}
            @endif
        </span>
        @if (!$childGrupos->grupos->count() && $canDelete)
            <span class="acoes-sortable">
                <x-form.wire-button
                    class="btn btn-danger text-danger btn-icon"
                    class-icon="w-6 h-6"
                    click="getSelectedId({{ $childGrupos->id }}, 'delete')"
                    action="delete"
                    data-toggle="modal"
                    data-target="#excluirModal"
                    />
            </span>
        @endif
        <div class="clear"></div>
@endif
    @if ($childGrupos->grupos)
        <x-alpine.grupo-sortable :useFallback="true" :canDelete="$canDelete">
            @if (count($childGrupos->grupos) > 0)
                @php
                    $subgrupo++;
                @endphp
                @foreach ($childGrupos->grupos as $subGrupos)
                    <x-subgrupo :childGrupos="$subGrupos" :principal="false" :subgrupo="$subgrupo" :canDelete="$canDelete" />
                @endforeach
            @else
                @php
                    $subgrupo = 2;
                @endphp
            @endif
        </x-alpine.grupo-sortable>
    @endif
@if ($principal === false)
    </div>
@endif