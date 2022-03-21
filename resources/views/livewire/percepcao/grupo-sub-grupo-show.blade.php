@php
/**
 @endphp
<li wire:sortable-group.item="{{ $childGrupos->id }}" wire:key="group-{{ $childGrupos->id }}">
    {{ $childGrupos->texto }}
    @if ($childGrupos->grupos)                    
            @if (count($childGrupos->grupos) > 0)
            <ul wire:sortable-group.item-group="{{ $childGrupos->id }}">
                &nbsp;
                @foreach ($childGrupos->grupos as $subGrupos)
                    @livewire('percepcao.grupo-sub-grupo-show', ['childGrupos' => $subGrupos, 'subgrupo' => false], key(now() . $subGrupos->id))
                @endforeach                
            </ul>
            @endif        
    @endif
</li>
@php
*/
@endphp

@php
/**
 @endphp
    @if ($childGrupos->grupos)
    <li wire:sortable-group.item="{{ $childGrupos->id }}" wire:key="subgroup-{{ $childGrupos->id }}">
    <span wire:sortable.handle>{{ $childGrupos->texto }}</span>
        <ul wire:sortable-group.item-group="{{ $childGrupos->id }}">
            &nbsp;
            @if (count($childGrupos->grupos) > 0)
                @foreach ($childGrupos->grupos as $subGrupos)
                    @livewire('percepcao.grupo-sub-grupo-show', ['childGrupos' => $subGrupos, 'subgrupo' => false], key(now() . $subGrupos->id))
                @endforeach
            @endif
        </ul>
        </li>
    @endif
    @php
*/
 @endphp

 @php
/**
 @endphp
@if ($subgrupo === true)
<li wire:sortable-group.item="{{ $childGrupos->id }}" wire:key="subgroup-{{ $childGrupos->id }}">
    <span wire:sortable.handle>{{ $childGrupos->texto }}</span>
@endif
    @if ($childGrupos->grupos)                   
        <ul wire:sortable-group.item-group="{{ $childGrupos->id }}">
            &nbsp; 
            @if (count($childGrupos->grupos) > 0)            
                @foreach ($childGrupos->grupos as $subGrupos)
                    @livewire('percepcao.grupo-sub-grupo-show', ['childGrupos' => $subGrupos, 'subgrupo' => true], key(now() . $subGrupos->id))
                @endforeach                            
            @endif        
        </ul>
    @endif
@if ($subgrupo === true)
</li>
@endif
@php
*/
@endphp

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