<div>
    <div class="">
        <h2 class="">
            <span>Consultas</span>
            <i class="fas fa-angle-right"></i> {{ ucfirst(end($path)) }}
        </h2>
        <hr>
    </div>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="col-sm-8">
            <x-form.wire-select
                model="percepcaoSelected"
                label="<span class='bold'>Selecione a percepção:</span>"
                :options="$this->options"
                wire:loading.attr="disabled"
                >
                <option disabled value="">PERCEPÇÃO - SEMESTRE/ANO</option>
            </x-form.wire-select>
            <div wire:loading wire:target="percepcaoSelected">
                Aguarde, carregando as informações...
            </div>

            @isset ($optionDisciplinas)
                <div class="pb-5 table-responsive div-rounded" wire:loading.remove>
                    <table class="table table-stripped table-hover table-bordered responsive">
                        <tr>
                            <th>Disciplina</th>
                            <th>Turma</th>
                            <th>Alunos matriculados</th>
                            <th>Total de respostas válidas</th>
                        </tr>
                        @foreach ($optionDisciplinas as $disciplina)
                            <tr>
                                <td>{{ $disciplina->coddis }} - {{ $disciplina->nomdis }}</td>
                                <td>{{ $disciplina->codtur }}</td>
                                <td>{{ $totalAlunosMatriculadosNaDisciplina[$disciplina->id] }}</td>
                                <td>{{ $disciplina->total_de_respostas }} ({{ $porcentagemDeRespostasValidas[$disciplina->id] }})</td>
                            </tr>
                        @endforeach
                    <table>
                </div>
            @endisset
        </div>
    </div>
</div>