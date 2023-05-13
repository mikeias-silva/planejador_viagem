<div class="row mb-2">
    <div class="col-6">
        <label for="" class="form-label">Nome Trajeto</label>
        <input type="text" name="nome_trajeto" id="" class="form-control"
               value="{{old('nome_trajeto') ?? $rota->nome_trajeto ?? ''}}">
    </div>
    <div class="col-3">
        <label for="" class="form-label">Dia da viagem</label>
        <input type="date" name="data_viagem" id="" class="form-control" value="{{old('data_viagem') ?? $rota->data_viagem ?? ''}}">

    </div>
</div>
<div class="pac-card" id="pac-card">
    <div>
        <div id="title">Origem / Destino</div>
        <div id="type-selector" class="pac-controls">
        </div>
    </div>
    <div id="pac-container" class="row p-2">
        <div class="col-6">
            <label for="">Local de partida</label>
            <input id="input-local" type="text" placeholder="Insira local de partida" class="form-control"/>
        </div>
        <div class="col-6">
            <label for="">Local de Destino</label>
            <input id="input-destino" type="text" placeholder="Insira seu desitno" class="form-control"/>
        </div>
    </div>
</div>

<div id="map"></div>

<div id="infowindow-content">
    <span id="place-name" class="title"></span><br/>
    <span id="place-address"></span>
</div>


<div class="row mb-3">
    <div class="col-4">
        <label for="" class="form-label">Partida</label>
        <input type="text" id="partida_nome" name="partida_nome" class="form-control" readonly
               value="{{$rota->partida_nome ?? ''}}"
        >
    </div>
    <div class="col-8">
        <label for="" class="form-label">Endereço</label>
        <input type="text" id="partida_endereco" name="partida_endereco" class="form-control" readonly
               value="{{$rota->partida_endereco ?? ''}}"
        >
    </div>
    <div class="col-3">
{{--        <label for="" class="form-label">Longitude</label>--}}
        <input type="hidden" name="partida_longitude" id="partida_longitude" class="form-control" readonly
               value="{{$rota->partida_longitude ?? ''}}"
        >
    </div>
    <div class="col-3">
{{--        <label for="" class="form-label">Latitude</label>--}}
        <input type="hidden" name="partida_latitude" id="partida_latitude" class="form-control" readonly
               value="{{$rota->partida_latitude ?? ''}}"
        >
    </div>
</div>
<div class="row mb-3">
    <div class="col-4">
        <label for="" class="form-label">Destino</label>
        <input type="text" id="destino_nome" name="destino_nome" class="form-control" readonly
               value="{{$rota->destino_nome ?? ''}}"
        >
    </div>

    <div class="col-8">
        <label for="" class="form-label">Endereço</label>
        <input type="text" id="destino_endereco" name="destino_endereco" class="form-control" readonly
               value="{{$rota->destino_endereco ?? ''}}"
        >
    </div>
    <div class="row">
        <div class="col-3">
{{--            <label for="" class="form-label">Longitude</label>--}}
            <input type="hidden" name="destino_longitude" id="destino_longitude" class="form-control" readonly
                   value="{{$rota->destino_longitude ?? ''}}"
            >
        </div>
        <div class="col-3">
{{--            <label for="" class="form-label">Latitude</label>--}}
            <input type="hidden" name="destino_latitude" id="destino_latitude" class="form-control" readonly
                   value="{{$rota->destino_latitude ?? ''}}"
            >
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary">Próximo</button>
@push('child-script')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{config('app.api_google_key')}}&callback=initMap&libraries=places&v=weekly"
        defer>
    </script>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: {lat: -25.0973545, lng: -50.1593586}, // centralizado emponta grossa
                zoom: 13,
                mapTypeControl: false,
            });

            const card = document.getElementById("pac-card");
            const input = document.getElementById("input-local");
            const inputDestino = document.getElementById("input-destino");
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

            const autocompleteDestino = new google.maps.places.Autocomplete(
                inputDestino,
                options
            );

            autocompleteDestino.bindTo("bounds", map)
            autocomplete.bindTo("bounds", map);


            const infowindow = new google.maps.InfoWindow();
            const infowindowContent = document.getElementById("infowindow-content");

            infowindow.setContent(infowindowContent);

            const marker = new google.maps.Marker({
                map,
                anchorPoint: new google.maps.Point(0, -29),
            });

            autocompleteDestino.addListener("place_changed", () => {
                infowindow.close();
                marker.setVisible(true);

                console.log(autocompleteDestino.getPlace().geometry);
                const place_destino = autocompleteDestino.getPlace();

                if (!place_destino.geometry || !place_destino.geometry.location) {
                    window.alert(
                        "No details available for input: '" + place.name + "'"
                    );
                    return;
                }
                var destino_nome = document.getElementById('destino_nome');
                destino_nome.value = place_destino.name
                var destino_endereco = document.getElementById('destino_endereco');
                destino_endereco.value = place_destino.formatted_address;
                var destino_latitude = document.getElementById('destino_latitude');
                destino_latitude.value = place_destino.geometry.location.lat();
                var destino_longitude = document.getElementById('destino_longitude');
                destino_longitude.value = place_destino.geometry.location.lng();

                if (place_destino.geometry.viewport) {
                    map.fitBounds(place_destino.geometry.viewport);
                } else {
                    map.setCenter(place_destino.geometry.location);
                    map.setZoom(17);
                }
                marker.setPosition(place_destino.geometry.location);
                marker.setVisible(true);
                infowindowContent.children["place-name"].textContent = place_destino.name;
                infowindowContent.children["place-address"].textContent =
                    place_destino.formatted_address;
                infowindow.open(map, marker);
            })
            autocomplete.addListener("place_changed", () => {
                infowindow.close();
                marker.setVisible(false);
                const place = autocomplete.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    window.alert(
                        "No details available for input: '" + place.name + "'"
                    );
                    return;
                }

                var partida_nome = document.getElementById('partida_nome');
                partida_nome.value = place.name
                var partida_endereco = document.getElementById('partida_endereco');
                partida_endereco.value = place.formatted_address;
                var partida_latitude = document.getElementById('partida_latitude');
                partida_latitude.value = place.geometry.location.lat();
                var partida_longitude = document.getElementById('partida_longitude');
                partida_longitude.value = place.geometry.location.lng();
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
        }

        window.initMap = initMap;
    </script>
@endpush

