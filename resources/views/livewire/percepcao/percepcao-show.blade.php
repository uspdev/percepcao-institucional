<div>
    <button wire:click="selectedId('', 'create')"  class="btn btn-primary" data-toggle="modal">
        Cadastrar Percepção Institucional
    </button>
    <br><br>

    @if ($action === 'create' || $action === 'update' || $action === 'copy')
        <div>
            @livewire('percepcao.percepcao-create', ['action' => $action], key(time()))
        </div>
    @endif

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
                            <td>
                                <a class="" href="{{ route('percepcao.show', $percepcao) }}">
                                    {{ $percepcao->settings['nome'] }} ({{ $percepcao->ano ?? '' }}/{{ $percepcao->semestre ?? '' }})
                                    <span class="ml-3">
                                        {!! $percepcao->isAberto() ? '<span class="badge badge-primary">Aberto</span>' : '' !!}
                                        {!! $percepcao->isFinalizado() ? '<span class="badge badge-secondary">Finalizado</span>' : '' !!}
                                        {!! $percepcao->isFuturo() ? '<span class="badge badge-success">Em elaboração</span>' : '' !!}
                                </span>
                            </a>
                            </td>
                            <td class="{{ $percepcao->isAberto() ? 'font-weight-bold' : '' }}">
                                {{ $percepcao->dataDeAbertura->format('d/m/Y H:i') ?? '' }}
                            </td>
                            <td class="{{ $percepcao->isAberto() ? 'font-weight-bold' : '' }}">
                                {{ $percepcao->dataDeFechamento->format('d/m/Y H:i') ?? '' }}
                            </td>
                            {{-- <td>{{ $percepcao->ano ?? '' }}</td>
                            <td>{{ $percepcao->semestre ?? '' }}</td> --}}
                            <td>
                                {{ $percepcao->settings['totalDeAlunosMatriculados'] }}
                            </td>
                            <td>
                                {{ $percepcao->settings['totalDeDisciplinas'] }}
                            </td>
                            <td>
                                <div class="form-inline">
                                    <span class="mt-2">{{ count($percepcao->settings['membrosEspeciais']) }}</span>
                                    @livewire('percepcao.toggle-button', [
                                        'model' => $percepcao,
                                        'field' => 'liberaConsultaMembrosEspeciais',
                                    ],
                                    key('liberaConsultaMembrosEspeciais-' . $percepcao->id)
                                    )

                                </div>
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
                            <td>
                                {{ $percepcao->settings['nome'] }}
                            </td>
                            <td width=''>
                                <div>
                                    <x-form.wire-button
                                        class="btn btn-primary text-primary btn-icon"
                                        class-icon="w-6 h-6"
                                        click="selectedId({{ $percepcao->id }}, 'update')"
                                        action="update"
                                    />

                                    <x-form.wire-button
                                        class="btn btn-info text-info btn-icon"
                                        class-icon="w-6 h-6"
                                        click="selectedId({{ $percepcao->id }}, 'copy')"
                                        action="copy"
                                    />

                                    @if ($percepcao->isFuturo())
                                        <x-form.wire-button
                                            class="btn btn-danger text-danger btn-icon"
                                            class-icon="w-6 h-6"
                                            click="selectedId({{ $percepcao->id }}, 'delete')"
                                            action="delete"
                                            data-toggle="modal"
                                            data-target="#excluirModal"
                                        />
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($percepcao->isFuturo())
            <!-- Modal para exclusão -->
            <x-modal.delete />
        @endif
    @else
        <br><br>
        <div class="content text-center font-weight-bold">Nenhuma percepção foi cadastrada ainda!</div>
        <br><br>
    @endif
</div>
