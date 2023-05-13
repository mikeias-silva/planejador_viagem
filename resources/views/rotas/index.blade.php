@extends('layouts.master')
@section('content')
    @include('messages.error')

    <h2>Planejamento de viagem</h2>
    <div>
        <a href="{{route('rotas.create')}}" class="btn btn-primary">Nova Viagem</a>
    </div>
    <table class="table">
        <tr>
            <th>Nome</th>
            <th>Data da viagem</th>
            <th>Partida</th>
            <th>Destino</th>
            <th>Opções</th>
        </tr>
        @if(empty($rotas))
            <tr>
                <td colspan="5">Nenhum viagem cadastrado</td>
            </tr>
        @else
        @endif
        @foreach($rotas as $rota)
            <tr>
                <td><a href="{{route('rotas.show', [$rota->id])}}">  {{$rota->nome_trajeto}}</a></td>
                <td>{{$rota->data_viagem}}</td>
                <td>{{$rota->partida_nome}}</td>
                <td>{{$rota->destino_nome}}</td>
                <td><a href="{{route('rotas.edit', [$rota->id])}}"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="{{route('rota.deletar', [$rota->id])}}"><i class="fa-solid fa-trash text-danger"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
