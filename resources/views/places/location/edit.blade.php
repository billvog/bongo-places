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
      <x-place.locationMap :place="$place" isMarkerDraggable="{{ true }}" />
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
      lat: {{ $place->coordinates->latitude }},
      lng: {{ $place->coordinates->longitude }}
    }

    const map = window.placeMap.mapboxMap
    const createOrUpdateMarker = window.placeMap.createOrUpdateMarker

    // Add the control to the map.
    map.addControl(
      new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl,
        marker: false
      })
    );

    // Add marker when clicking the map.
    map.on('click', (event) => {
      let coordinates = event.lngLat;

      coordinatesLatField.value = coordinates.lat;
      coordinatesLngField.value = coordinates.lng;

      createOrUpdateMarker(coordinates);
    });

    // Reset coordinates to their initial value.
    resetCoordinatesButton.addEventListener('click', () => {
      createOrUpdateMarker(initialCoordinates);
      map.flyTo({
        center: initialCoordinates
      });
    });
  </script>
@endpush
