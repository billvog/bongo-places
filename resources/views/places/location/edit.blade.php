@extends('layouts.base')

@push('styles')
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css">
  <link rel="stylesheet"
    href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css">
@endpush

@section('content')
  <div>
    <a href="{{ route('places.edit', $place) }}">Back</a>
  </div>

  <div class="space-y-2">
    <h1>Edit location:</h1>
    <div>
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
  </div>

  <x-form :action="route('places.location.update', $place)" method="post">
    @method('patch')

    <div class="flex flex-col">
      <label for="location">Where's that?</label>
      <input name="location" id="location" placeholder="Location of your place"
        value="{{ old('location', $place->location) }}" required />
    </div>

    <div class="flex flex-col">
      <label>A little more precise?</label>
      <div class="text-sm text-zinc-500 mb-2">
        Find where your place is located on the map.
      </div>
      <div id="map" class="w-full h-[400px]"></div>
    </div>

    <input type="number" name="coordinates[latitude]" id="coordinates[latitude]"
      value="{{ old('coordinates[latitude]', $place->coordinates->latitude) }}" step="any" hidden required>
    <input type="number" name="coordinates[longitude]" id="coordinates[longitude]"
      value="{{ old('coordinates[longitude]', $place->coordinates->longitude) }}" step="any" hidden required>

    <div class="pt-4">
      <button type="submit">Update</button>
    </div>
  </x-form>
@endsection

@push('javascripts')
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
  <script type="module">
    const coordinatesLatField = document.getElementById('coordinates[latitude]');
    const coordinatesLngField = document.getElementById('coordinates[longitude]');

    var marker = null;

    mapboxgl.accessToken = 'pk.eyJ1IjoiYmlsbHZvZyIsImEiOiJjbG0zczB6bWcyZnZ3M2xwNjNiOXFnMnJ0In0.b3HHw4P9LUQzwS1fxA8IlQ';

    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v12',
      center: {
        lat: parseFloat(coordinatesLatField.value),
        lng: parseFloat(coordinatesLngField.value)
      },
      zoom: 10
    });

    // Add the control to the map.
    map.addControl(
      new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl,
        marker: false
      })
    );

    map.on('load', () => {
      let existingCoordinates = {
        lat: parseFloat(coordinatesLatField.value),
        lng: parseFloat(coordinatesLngField.value)
      }

      createOrUpdateMarker(existingCoordinates);

      map.flyTo({
        center: existingCoordinates
      });
    });

    // Add marker when clicking the map.
    map.on('click', (event) => {
      let coordinates = event.lngLat;

      coordinatesLatField.value = coordinates.lat;
      coordinatesLngField.value = coordinates.lng;

      createOrUpdateMarker(coordinates);
    });

    function createOrUpdateMarker(coordinates) {
      if (marker == null) {
        marker = new mapboxgl.Marker({
          draggable: true,
          color: "#F5AC2F",
        }).setLngLat(coordinates).addTo(map);
      } else {
        marker.setLngLat(coordinates);
      }
    }
  </script>
@endpush
