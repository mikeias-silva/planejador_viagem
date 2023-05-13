@extends('layouts.master')
@section('content')
    <form action="{{route('rota.excluir', [$rota->id])}}" method="post">
        @csrf
        @method('DELETE')
        <h2>Deletar viagem</h2>
        <div class="card">
            <h5 class="card-header bg-danger-subtle">Excluir</h5>
            <div class="card-body">
                <h5 class="card-title mb-4">Voce tem certeza que deseja excluir essa viagem?</h5>
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
                <button type="submit" class="btn btn-danger">Deletar</button>
            </div>
        </div>
    </form>

@endsection
