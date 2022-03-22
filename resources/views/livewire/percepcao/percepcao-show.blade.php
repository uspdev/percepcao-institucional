@section('styles')
  @parent
  <style>
    a.btn-acao:hover {
      text-decoration: none;
    }
    .btn-icon {
      background-color: transparent;
      background-image: none;
      border: 0;
    }
    .btn-icon:hover {
      color: #fff !important;
    }
    .btn-icon:focus {
      background-color: transparent;
      background-image: none;
      border: 0;
      box-shadow: none;
    }
    .div-rounded {
      border-radius: 0.3rem !important;
      border-width: 4px;
      background-color: #f5f5f5;
      padding: 5px;
    }
    .table-bordered {
      background-color: #fff;
    }
    .table thead th {
      vertical-align: middle;
    }
  </style>
@endsection

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
                            <td>{{ $percepcao->totalDeAlunosMatriculados ?? '' }}</td>
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
                                    <a href="avaliar/preview/{{ $percepcao->id }}" class="btn-acao">
                                        <x-form.wire-button
                                            class="btn btn-dark text-dark btn-icon"
                                            action="preview"
                                          />
                                    </a>
                                    <x-form.wire-button
                                        class="btn btn-primary text-primary btn-icon"                    
                                        click="selectedId({{ $percepcao->id }}, 'update')"
                                        action="update"
                                        data-toggle="modal" 
                                        data-target="#percepcaoModal"
                                      />
                                    <x-form.wire-button
                                        class="btn btn-danger text-danger btn-icon"                    
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
        <div wire:ignore.self class="modal fade" id="excluirModal" tabindex="-1" role="dialog" aria-labelledby="excluirModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="excluirModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cancelar</button>
                        <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Sim, excluir</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <br><br>
        <div class="content text-center font-weight-bold">Nenhuma percepção foi cadastrada ainda!</div>
        <br><br>
    @endif
        @include('percepcao.partials.modal')
</div>
