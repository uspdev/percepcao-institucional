<div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      Relatórios
    </h5>
  </div>
  <div class="card-body">
    <div>
      Respostas contabilizadas: <span class="badge badge-pill badge-primary">{{ $percepcao->contarRespostas() }}</span><br>
      @if (!$percepcao->isFinalizado())
        Os relatórios estarão disponíveis depois que a Percepção estiver finalizada.
      @else
          <div>
              <x-form.wire-select
                  label="Por departamento:"
                  onChange="if (this.value) { window.location='{{ route('percepcao.disciplina.relatorio', ['percepcao' => $percepcao->id]) }}/' + this.value; this.value = ''; } "
                  >
                  <option value=''>Selecione um departamento</option>
              @foreach ($departamentos as $departamento)
                  <option value="{{ $departamento['nomabvset'] }}">{{ $departamento['nomabvset'] }}</option>
              @endforeach
                  <option value='all'>Demais departamentos</option>
              </x-form.wire-select>
          </div>
          por disciplina<br>
          por docente<br>
          por coordenador
    </div>
    @endif
  </div>
</div>
