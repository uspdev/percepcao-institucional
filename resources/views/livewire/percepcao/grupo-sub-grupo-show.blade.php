@if ($principal === false)
    <div data-sortable-id="{{ $childGrupos->id }}" class="list-group-item nested-{{ $subgrupo }}">{{ $childGrupos->texto }}
@endif
    @if ($childGrupos->grupos)  
    <div class="list-group nested-sortable">      
        @if (count($childGrupos->grupos) > 0)
            @php
                $subgrupo++;
            @endphp                
            @foreach ($childGrupos->grupos as $subGrupos)
                @livewire('percepcao.grupo-sub-grupo-show', ['childGrupos' => $subGrupos, 'subgrupo' => $subgrupo, 'principal' => false], key($subGrupos->id . time()))
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