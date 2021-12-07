@extends('templates.template')

@section('content')

<form method="post" action="{{url("percepcao-institucional/gestao-sistema/percepcao")}}">
@csrf
@include('percepcao.partials.form')
</form>

@endsection
