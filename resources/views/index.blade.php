@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if (empty($percepcao))
          @include('partials.index-sem-percepcao')
        @else
          @include('partials.index-aberto')
        @endif
      </div>
    </div>
  </div>
@endsection
