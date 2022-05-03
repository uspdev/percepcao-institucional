@if ($principal === false)
    <div id="grupo-{{ $childGrupos->id }}" class="pl-{{ $subgrupo }}">
    <span class="form-group form-check">{{ $childGrupos->texto }}</span>
@endif
    @if ($childGrupos->grupos)
        <div id="list-subgrupo-{{ $childGrupos->id }}" class="">
            @if (count($childGrupos->grupos) > 0)                
                @foreach ($childGrupos->grupos as $subGrupos)
                    <x-list-subgrupo :childGrupos="$subGrupos" :principal="false" :subgrupo="$subgrupo" />
                @endforeach
            @else
                @php
                    $subgrupo = 4;
                @endphp
            @endif
            </div>
        @endif
@if ($principal === false)
    </div>
@endif