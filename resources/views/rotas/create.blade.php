@extends('layouts.master')
@section('content')
    <form action="{{route('rotas.store')}}" method="post">
        @csrf
        <h3>Novo roteiro de viagem</h3>
        @include('rotas.form')
    </form>
@endsection
