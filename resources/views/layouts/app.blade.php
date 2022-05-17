@extends('laravel-usp-theme::master')

@section('styles')
    @parent
    @livewireStyles
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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>    
    <script>
        window.addEventListener('closeModal', event => {
            $('#percepcaoModal').modal('hide');
        });

        window.addEventListener('openModal', event => {
            $('#percepcaoModal').modal('show');
        })
    </script>
@endsection
