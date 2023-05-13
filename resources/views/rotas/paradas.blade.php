@extends('layouts.master')
@section('content')

  @include('messages.error')
    <h3>Adicionar paradas</h3>
    <body>
    <div class="pac-card" id="pac-card">
        <div>
            <div id="title">Pontos de Parada</div>
            <div id="type-selector" class="pac-controls">
            </div>
        </div>
        <div id="pac-container">
            <label for="" class="form-label">Parada</label>
            <input id="pac-input" type="text" placeholder="Insira sua parada" class="form-control"/>
        </div>
    </div>

    <div id="map"></div>

    <div id="infowindow-content">
        <span id="place-name" class="title"></span><br/>
        <span id="place-address"></span>
    </div>

    <form action="{{route('rota.storeParadas')}}" method="post">
        @csrf
        <table id="tabelaDestinos" class="table">
            <thead>
            <tr>
                <th>Parada</th>
                <th>Endereço</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <input type="hidden" name="rota_id" value="{{$rota->id}}">
        <button type="submit" class="btn btn-primary">Roteirizar</button>
    </form>
    @push('child-script')
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{config('app.api_google_key')}}&callback=initMap&libraries=places&v=weekly"
            defer>
        </script>
        <script>
            let arrayObjetoDestino = [];
            function initMap() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: {lat: -25.0973545, lng: -50.1593586},
                    zoom: 13,
                    mapTypeControl: false,
                });

                let tabelaDestinos = document.getElementById('tabelaDestinos');

                const card = document.getElementById("pac-card");
                const input = document.getElementById("pac-input");
                const options = {
                    fields: ["formatted_address", "geometry", "name"],
                    strictBounds: false,
                    types: ["establishment"],
                };

                map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

                const autocomplete = new google.maps.places.Autocomplete(
                    input,
                    options
                );

                autocomplete.bindTo("bounds", map);

                const infowindow = new google.maps.InfoWindow();
                const infowindowContent = document.getElementById("infowindow-content");

                infowindow.setContent(infowindowContent);

                const marker = new google.maps.Marker({
                    map,
                    anchorPoint: new google.maps.Point(0, -29),
                });

                autocomplete.addListener("place_changed", () => {
                    infowindow.close();
                    marker.setVisible(false);

                    const place = autocomplete.getPlace();

                    console.log(place);
                    if (!place.geometry || !place.geometry.location) {
                        window.alert(
                            "No details available for input: '" + place.name + "'"
                        );
                        return;
                    }

                    let nomeDestino = place.name;
                    let enderecoDestino = place.formatted_address;
                    let latitudeDestino = place.geometry.location.lat();
                    let longitudeDestino = place.geometry.location.lng();

                    let destino = {nomeDestino, enderecoDestino, latitudeDestino, longitudeDestino};

                    adicionarDestino(destino);

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }

                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);
                    infowindowContent.children["place-name"].textContent = place.name;
                    infowindowContent.children["place-address"].textContent =
                        place.formatted_address;
                    infowindow.open(map, marker);
                });
                const removerLinha = (event) => {
                    const linha = event.target.closest('tr');
                    linha.remove();
                };

                document.addEventListener('click', function (event) {
                    if (event.target.classList.contains('remover')) {
                        removerLinha(event);

                    }
                });

                function adicionarDestino(destino) {

                    var novaLinha = document.createElement('tr');
                    novaLinha.innerHTML = `
                    <td><input type="hidden" name="nome_destino[]" id="" value="${destino.nomeDestino}"> ${destino.nomeDestino}</td>
                    <td>${destino.enderecoDestino}</td>
                    <td><input type="hidden" name="destino_latitude[]" id="" value="${destino.latitudeDestino}"/> ${destino.latitudeDestino}</td>
                    <td><input type="hidden" name="destino_longitude[]" id="" value="${destino.longitudeDestino}"/> ${destino.latitudeDestino}</td>
                    <td>
                        <button class="btn btn-outline-danger remover">Remover</button>
                    </td>
                `;
                    tabelaDestinos.appendChild(novaLinha);
                    arrayObjetoDestino.push(destino)
                }


            }

            window.initMap = initMap;
        </script>
    @endpush
    </body>
@endsection
