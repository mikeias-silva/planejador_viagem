@extends('layouts.master')
@section('content')
    <form action="{{route('rotas.update', [$rota->id])}}" method="post">
        @method('put')
        @csrf
        <h2>Editar viagem</h2>
        @include('rotas.form')
    </form>
@endsection
