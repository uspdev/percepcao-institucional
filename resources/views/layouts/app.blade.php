@extends('laravel-usp-theme::master')


@section('styles')
  @parent
  @livewireStyles
  <style>
    .bold {
      font-weight: bold
    }

  </style>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

@endsection

@section('flash')
  @if ($errors->any())
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
      @if (Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
          <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a>
        </p>
      @endif
    @endforeach
  </div>
@endsection

@section('javascripts_bottom')
  @parent
  @livewireScripts
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
  <script>
    window.addEventListener('closeModal', event => {
      $('#percepcaoModal').modal('hide');
    });

    window.addEventListener('openModal', event => {
      $('#percepcaoModal').modal('show');
    })
  </script>
@endsection
