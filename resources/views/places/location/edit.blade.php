@extends('layouts.base')

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
      <div class="flex flex-row justify-between items-center">
        <div class="flex flex-col">
          <label>A little more precise?</label>
          <div class="text-sm text-zinc-500 mb-2">
            Find where your place is located on the map.
          </div>
        </div>
        <div>
          <button type="button" id="resetCoordinatesButton" class="link text-sm"
            title="Reset marker to inital coordinates.">reset</button>
        </div>
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
  @vite('resources/js/mapbox.js')
  <script type="module">
    const coordinatesLatField = document.getElementById('coordinates[latitude]');
    const coordinatesLngField = document.getElementById('coordinates[longitude]');

    const resetCoordinatesButton = document.getElementById('resetCoordinatesButton');

    const initialCoordinates = {
      lat: parseFloat(coordinatesLatField.value),
      lng: parseFloat(coordinatesLngField.value)
    }

    // This variable will hold the marker object.
    var marker = null;

    // Initilize our map.
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmlsbHZvZyIsImEiOiJjbG0zczB6bWcyZnZ3M2xwNjNiOXFnMnJ0In0.b3HHw4P9LUQzwS1fxA8IlQ';
    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v12',
      center: initialCoordinates,
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

    // Initialize the marker when map loads
    // and center to it.
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

    // Create (or update) a marker at the specified coordinates.
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

    // Reset coordinates to their initial value.
    resetCoordinatesButton.addEventListener('click', () => {
      createOrUpdateMarker(initialCoordinates);
      map.flyTo({
        center: initialCoordinates
      });
    });
  </script>
@endpush
