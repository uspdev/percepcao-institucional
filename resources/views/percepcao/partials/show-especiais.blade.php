<div class="card">
  <div class="card-header">
    <h5 class="mb-0">
      Membros Especiais
      <span class="badge badge-primary badge-pill">{{ count($membrosEspeciais) }}</span>
    </h5>
    <span class="text-secondary ml-2">
      Membros especiais poderão visualizar todos os resutados da percepção.
    </span>
  </div>
  <div class="card-body">
    <div>
      <form method="post" action="{{ route('percepcao.updateEspeciais', $percepcao) }}">
        @method('put')
        @csrf
        <div class="input-group">
          <input class="form-control" type="number" name="codpes" value="{{ old('membrosEspeciais') }}"
            placeholder="Digite o codpes para adicionar...">
          <div class="input-group-append">
            <input class="btn btn-outline-primary" type="submit" name="submit" value="OK">
          </div>
        </div>
      </form>
      @foreach ($membrosEspeciais as $membro)
        <div class="form-inline delete-form-confirm">
          {{ $membro }} {{ json_encode(\Uspdev\Replicado\Pessoa::obterNome($membro) ?? '') }}
          <form method="POST" action="{{ route('percepcao.destroyEspeciais', $percepcao) }}">
            @method('delete')
            @csrf
            <input type="hidden" name="codpes" value="{{ $membro }}" />
            <button class="btn btn-sm text-danger" title="Remover"><i class="fas fa-trash"></i></button>
          </form>
        </div>
      @endforeach
    </div>

  </div>
</div>
