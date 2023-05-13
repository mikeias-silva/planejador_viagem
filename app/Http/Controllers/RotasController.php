<?php

namespace App\Http\Controllers;

use App\Http\Requests\RotasStoreRequest;
use App\Models\Rotas;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use function GuzzleHttp\Promise\all;

class RotasController extends Controller
{

    public function index()
    {
        $rotas = Rotas::all();

//        dd($rotas[0]->getAttributes());
//        dd($rotas);
        foreach ($rotas as $rota) {
            $rota->data_viagem = Carbon::createFromFormat('Y-m-d', $rota->data_viagem)->format('d/m/Y');

        }
        return view('rotas.index', compact('rotas'));
    }

    public function create()
    {


        $client = new Client();

        $waypoints = [
            [13.4050, 52.5200], // Waypoint 1 (longitude, latitude)
            [0.1278, 51.5074], // Waypoint 2 (longitude, latitude)
        ];

//        $response = $client->request('GET', 'https://api.openrouteservice.org/v2/directions/driving-car', [
//            'headers' => [
//                'Authorization' => '5b3ce3597851110001cf624818224d713cf64e1c89d92fda782b18ec',
//            ],
//            'query' => [
//                'start' => [12.9716, 77.5946], // Origem (longitude, latitude)
//                'end' => [12.9716, 77.5946], // Destino (longitude, latitude)
//
//            ],
//        ]);
//
//        $data = json_decode($response->getBody(), true);
//        dd($data);
        return view('rotas.create');
    }

    public function store(RotasStoreRequest $request)
    {
        try {
            $newRota = Rotas::create($request->all());
            return view('rotas.paradas', ['rota' => $newRota]);
        } catch (\Exception $exception) {
            dd($exception);
            return view('rotas.create')->with('Error', $exception->getMessage());
        }
    }

    public function show(Rotas $rota)
    {
        $rota->itinerario = json_decode($rota->itinerario, true);
        return view('rotas.diario_viagem', compact('rota'));
    }

    public function edit(Rotas $rota)
    {
        return view('rotas.edit', compact('rota'));
    }

    public function update(Request $request, Rotas $rota)
    {
        try {
            $rota->nome_trajeto = $request->nome_trajeto;
            $rota->data_viagem = $request->data_viagem;
            $rota->partida_nome = $request->partida_nome;
            $rota->partida_endereco = $request->partida_endereco;
            $rota->partida_latitude = $request->partida_latitude;
            $rota->partida_longitude = $request->partida_longitude;
            $rota->destino_nome = $request->destino_nome;
            $rota->destino_endereco = $request->destino_endereco;
            $rota->destino_latitude = $request->destino_latitude;
            $rota->destino_longitude = $request->destino_longitude;
            $rota->save();
            return view('rotas.paradas', compact('rota'));
        } catch (Exception $exception) {
            return redirect()->route('rotas.index', [$rota->id]);
        }
    }

    public function destroy(Rotas $rota)
    {
        try {
            $rota->delete();
            return redirect()->route('rotas.index');
            dd('oi');
        } catch (Exception $exception) {
            return redirect()->route('rotas.index')->withErrors($exception->getMessage());
        }
    }

    public function storeParadas(Request $request)
    {

        $objetoWaypoints = [];
        foreach ($request->nome_destino as $index => $destinos) {
            $arr =
                [
                    "location" =>
                        [
                            "lat" => $request->destino_latitude[$index],
                            "lng" => $request->destino_longitude[$index]
                        ]
                ];
            array_push($objetoWaypoints, $arr);
        }
        $rota = Rotas::find($request->rota_id);
        $objJson = json_encode($objetoWaypoints, JSON_UNESCAPED_SLASHES);
        $objJson = stripslashes($objJson);


        $rota->waypoints = $objJson;
        return redirect()->route('rota.roteirizar', [$rota->id]);
    }

    public function roteirizar(Rotas $rota)
    {
        $partida_latitude = $rota->partida_latitude;
        $partida_longitude = $rota->partida_longitude;
        $destino_latitude = $rota->destino_latitude;
        $destino_longitude = $rota->destino_longitude;
        $waypoints = json_decode($rota->waypoints);
        $client = new Client();

        $url = "https://maps.googleapis.com/maps/api/directions/json";

        $waypointsFormatado = [];

        if ($waypoints) {
            foreach ($waypoints as $waypoint) {
                // Extrair as coordenadas do waypoint
                $latitude = $waypoint->location->lat;
                $longitude = $waypoint->location->lng;


                $waypointFormatted = [
                    'location' => [
                        $latitude,
                        $longitude
                    ]
                ];


                array_push($waypointsFormatado, $waypointFormatted);
            }
        }

        try {

            $response = $client->request('GET', $url, [
                'query' => [
                    'origin' => "{$partida_latitude},{$partida_longitude}",
                    'destination' => "{$destino_latitude},{$destino_longitude}",
                    'waypoints' => $waypointsFormatado,
                    'key' => 'AIzaSyCX1b5sqz0XNQn7gQawN53X_Lioto9dVIs',
                    'language' => 'pt-BR'
                ]
            ]);
        } catch (Exception $exception) {
            dd($exception);
        }

        $data = json_decode($response->getBody()->getContents());

        $distancia = $data->routes[0]->legs[0]->distance;
        $duration = $data->routes[0]->legs[0]->duration;
        $itinerario = [
            'distancia' => $distancia,
            'duracao' => $duration
        ];

        if ($data->status === 'OK') {
            $rota->itinerario = json_encode($itinerario);
            $rota->save();
        }

        return redirect()->route('rotas.show', [$rota->id]);
    }

    public function editParadas(Rotas $rota)
    {
        $rota->itinerario = json_encode($rota->itinerario);

        return view('rotas.editParadas', compact('rota'));
    }

    public function deletar(Rotas $rota)
    {
        return view('rotas.delete', compact('rota'));
    }
}
