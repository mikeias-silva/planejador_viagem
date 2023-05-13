@extends('layouts.master')
@section('content')
    <div class="card text-center">
        <div class="card-header">
            <h4>{{$rota->nome_trajeto}}</h4>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-5">
                    <h5>Partida</h5>
                    <div class="">
                        <p>{{$rota->partida_nome}}</p>
                    </div>
                    <div class="">
                        <p>{{$rota->partida_endereco}}</p>
                    </div>
                </div>
                <div class="col-5">
                    <h5>Destino</h5>
                    <div class="">
                        <p>{{$rota->destino_nome}}</p>
                    </div>
                    <div class="">
                        <p>{{$rota->destino_endereco}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <h5 class="card-text">Tempo de viagem</h5>
                <h2 class="card-title">{{$rota->itinerario['duracao']['text']}}</h2>
                <h5 class="card-text">Distânca</h5>
                <h2 class="card-title">{{$rota->itinerario['distancia']['text']}}</h2>
            </div>
            <a href="{{route('rotas.index')}}" class="btn btn-primary">Ok</a>
        </div>
        <div class="card-footer text-muted">
            Viaje com Segurança!
        </div>
    </div>
@endsection
