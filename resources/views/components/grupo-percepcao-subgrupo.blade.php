@if ($principal === false)
    <div data-sortable-id="{{ $childGrupos->id }}" id="grupo-{{ $childGrupos->id }}" class="list-group-item nested-{{ $subgrupo }}">
        <span class="texto-sortable">
            {{ $childGrupos->texto }}
        </span>
        <div class="clear"></div>

        @livewire('percepcao.grupo-questao-show', ['grupo' => $childGrupos, 'percepcaoId' => $percepcaoId], key(time()))

@endif
    @if ($childGrupos->grupos)
        <div id="sortableAlpine" class="list-group nested-sortable">
            @if (count($childGrupos->grupos) > 0)
                @php
                    $subgrupo++;
                @endphp
                @foreach ($childGrupos->grupos as $subGrupos)
                    <x-grupo-percepcao-subgrupo :childGrupos="$subGrupos" :principal="false" :subgrupo="$subgrupo" :percepcaoId="$percepcaoId" />
                @endforeach
            @else
                @php
                    $subgrupo = 2;
                @endphp
            @endif
            </div>
        @endif
@if ($principal === false)
    </div>
@endif