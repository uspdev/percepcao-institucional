@extends('laravel-usp-theme::master')

@section('title')
Percepção Institucional
@endsection

@section('styles')
  @parent
  @livewireStyles
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endsection

@section('flash')
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' .$msg) }}
          <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a>
        </p>
      @endif
    @endforeach
  </div>
@endsection

@section('javascripts_bottom')
  @livewireScripts
  <script>
    window.addEventListener('closeModal', event => {
      $('#percepcaoModal').modal('hide');
    });

    window.addEventListener('openModal', event => {
      $('#percepcaoModal').modal('show');
    })
  </script>
@endsection
