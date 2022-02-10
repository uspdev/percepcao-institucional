@section('styles')
  @parent
  @livewireStyles
  <style>
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
                <button wire:click="selectedId({{ $percepcao->id }}, 'update')" class="btn btn-primary text-primary btn-icon" data-toggle="modal" data-target="#percepcaoModal">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M18.363 8.464l1.433 1.431-12.67 12.669-7.125 1.436 1.439-7.127 12.665-12.668 1.431 1.431-12.255 12.224-.726 3.584 3.584-.723 12.224-12.257zm-.056-8.464l-2.815 2.817 5.691 5.692 2.817-2.821-5.693-5.688zm-12.318 18.718l11.313-11.316-.705-.707-11.313 11.314.705.709z"/>
                  </svg>
                </button>
                <button wire:click="selectedId({{ $percepcao->id }}, 'delete')" class="btn btn-danger text-danger btn-icon" data-toggle="modal" data-target="#excluirModal">
                  <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19 24h-14c-1.104 0-2-.896-2-2v-17h-1v-2h6v-1.5c0-.827.673-1.5 1.5-1.5h5c.825 0 1.5.671 1.5 1.5v1.5h6v2h-1v17c0 1.104-.896 2-2 2zm0-19h-14v16.5c0 .276.224.5.5.5h13c.276 0 .5-.224.5-.5v-16.5zm-9 4c0-.552-.448-1-1-1s-1 .448-1 1v9c0 .552.448 1 1 1s1-.448 1-1v-9zm6 0c0-.552-.448-1-1-1s-1 .448-1 1v9c0 .552.448 1 1 1s1-.448 1-1v-9zm-2-7h-4v1h4v-1z"/>
                  </svg>
                </button>
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
