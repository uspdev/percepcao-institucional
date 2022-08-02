@extends('layouts.app')

@section('content')
  <h2 class="">
    <a href="{{ route('percepcaos.index') }}">Percepções</a>
    <i class="fas fa-angle-right"></i> {{ $percepcao->settings['nome'] }}
    ({{ $percepcao->ano }}/{{ $percepcao->semestre }})
    @include('percepcao.partials.badge-situacao')
  </h2>

  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-7">
          @include('percepcao.partials.show-principal')
        </div>
        <div class="col-md-5">
          @include('percepcao.partials.show-secundario')
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6">
      @include('percepcao.partials.show-textos')
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        @include('percepcao.partials.show-especiais')
      </div>
      @include('percepcao.partials.show-relatorios')
    </div>
  </div>
@endsection
