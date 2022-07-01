@foreach ($dadosCoordenador as $keyCoordenador => $coordenador)
<fieldset class="border p-2"
    id="{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}">

    <legend class="w-auto h6 text-info" data-toggle="collapse"
        data-target="#collapse-{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}"
        aria-expanded="false"
        aria-controls="collapse-{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}"
        style="cursor: pointer;">
        CURSO: {{ mb_strtoupper($coordenador['nomcur']) }}
    </legend>

    <div id="collapse-{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}"
        class="collapse show form-group text-justify">
        <div class="h6 pb-3">
            Coordenador:
            <span class="bold">
                {{ $coordenador['nompes'] }}
            </span>
        </div>

        <x-percepcao-avaliacao-create-questoes-repeticao :grupo="$grupo" :key="$keyCoordenador" />

        <br />
        @if (isset($grupo['grupos']))
            <x-percepcao-avaliacao-create-subgrupo :childGrupos="$grupo" :key="$keyCoordenador" :dadosRepeticao="$coordenador" />
        @endif

    </div>
    <div id="collapse-{{ $coordenador['codcur'] }}-{{ $coordenador['codhab'] }}-{{ $keyCoordenador }}" class="collapse form-group text-justify">
        Clique no título para exibir
    </div>
</fieldset>
<br />
@endforeach
