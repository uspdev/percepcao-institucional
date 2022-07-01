@foreach ($dadosDisciplina as $keyDisciplina => $disciplina)
<fieldset class="border p-2"
    id="{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}">

    <legend class="w-auto h6 text-info" data-toggle="collapse"
        data-target="#collapse-{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}"
        aria-expanded="false"
        aria-controls="collapse-{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}"
        style="cursor: pointer;">
        {{ mb_strtoupper($disciplina['nomdis']) }}
        ({{ mb_strtoupper($disciplina['coddis']) }})
    </legend>

    <div id="collapse-{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}"
        class="collapse show form-group text-justify">
        <div class="h6">
            Ministrante: <span class="bold">{{ $disciplina['nompes'] }}</span>
        </div>

        <div class="h6 pb-3">
            Turma: <span class="bold">{{ $disciplina['codtur'] }} - {{ $disciplina['tiptur'] }}</span>
        </div>

        @if (isset($grupo['questoes']))
            @include('livewire.avaliacao.partials.questoes')
            {{-- <x-percepcao-avaliacao-create-questoes-repeticao :grupo="$grupo" :key="$keyDisciplina" /> --}}
        @endif

        <br />
        @if (isset($grupo['grupos']))
            <x-percepcao-avaliacao-create-subgrupo :childGrupos="$grupo" :key="$keyDisciplina" :dadosModelo="$disciplina" />
        @endif

    </div>
    <div id="collapse-{{ $disciplina['coddis'] }}-{{ $keyDisciplina }}" class="collapse form-group text-justify">
        Clique no título para exibir
    </div>
</fieldset>
<br />
@endforeach