<div>
    <button wire:click="selectedId('', 'create')"  class="btn btn-primary" data-toggle="modal">
        Cadastrar Percepção Institucional
    </button>
    <br><br>

    <h2 class="text-center font-weight-bold">Lista de percepções</h2>
    <hr>
    @if($percepcoes->first())
        <div class="table-responsive div-rounded">
            <table class="table table-stripped table-hover table-bordered responsive">
                <thead>
                    <tr>
                        @foreach($columns as $key => $column)
                            <x-table.heading
                                :column="$column['name']"
                                :sortable="$column['sortable']"
                                :sortField="$sortField"
                                :direction="$sortDirection"
                                :text="$column['text']"
                                wire:key="{{ $key }}">
                            </x-table-heading>
                        @endforeach
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($percepcoes as $percepcao)
                        <tr>
                            <td>{{ $percepcao->id ?? '' }}</td>
                            <td>{{ $percepcao->dataDeAbertura->format('d/m/Y H:i') ?? '' }}</td>
                            <td>{{ $percepcao->dataDeFechamento->format('d/m/Y H:i') ?? '' }}</td>
                            <td>{{ $percepcao->ano ?? '' }}</td>
                            <td>{{ $percepcao->semestre ?? '' }}</td>
                            <td>
                                {{ $percepcao->totalDeAlunosMatriculados ?? '' }} 
                                <a href="{{ route('percepcao.alunos', $percepcao->id) }}" title="ver lista de alunos"><i class="fas fa-eye"></i></a>
                            </td>
                            <td>
                                @livewire('percepcao.toggle-button', [
                                    'model' => $percepcao,
                                    'field' => 'liberaConsultaMembrosEspeciais',
                                ],
                                key('liberaConsultaMembrosEspeciais-' . $percepcao->id)
                                )
                            </td>
                            <td>
                                @livewire('percepcao.toggle-button', [
                                    'model' => $percepcao,
                                    'field' => 'liberaConsultaDocente',
                                  ],
                                  key('liberaConsultaDocente-' . $percepcao->id)
                                )
                            </td>
                            <td>
                                @livewire('percepcao.toggle-button', [
                                    'model' => $percepcao,
                                    'field' => 'liberaConsultaAluno',
                                  ],
                                  key('liberaConsultaAluno-' . $percepcao->id)
                                )
                            </td>
                            <td width=''>
                                <div>
                                    <a href="gestao-sistema/percepcao/{{ $percepcao->id }}/add-questao" class="btn-acao" title="Gerenciar questões">
                                        <x-form.wire-button
                                            class="btn btn-dark text-dark btn-icon"
                                            class-icon="w-6 h-6"
                                            action="question"
                                          />
                                    </a>
                                    <a href="avaliar/preview/{{ $percepcao->id }}" class="btn-acao" title="Visualização prévia">
                                        <x-form.wire-button
                                            class="btn btn-dark text-dark btn-icon"
                                            class-icon="w-6 h-6"
                                            action="preview"
                                          />
                                    </a>
                                    <x-form.wire-button
                                        class="btn btn-primary text-primary btn-icon"
                                        class-icon="w-6 h-6"
                                        click="selectedId({{ $percepcao->id }}, 'update')"
                                        action="update"
                                        data-toggle="modal"
                                        data-target="#percepcaoModal"
                                      />
                                    <x-form.wire-button
                                        class="btn btn-danger text-danger btn-icon"
                                        class-icon="w-6 h-6"
                                        click="selectedId({{ $percepcao->id }}, 'delete')"
                                        action="delete"
                                        data-toggle="modal"
                                        data-target="#excluirModal"
                                      />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Modal para exclusão -->
        <x-modal.delete />
    @else
        <br><br>
        <div class="content text-center font-weight-bold">Nenhuma percepção foi cadastrada ainda!</div>
        <br><br>
    @endif
        @include('percepcao.partials.modal')
</div>
