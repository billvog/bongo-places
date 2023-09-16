@props(['place', 'isMarkerDraggable' => false])

@php
  $mapId = $place->id . '-map';
@endphp

<div class="flex">

  <div id="{{ $mapId }}" class="w-full h-[400px]"></div>

</div>

@pushOnce('javascripts')
  @vite('resources/js/mapbox.js')
  <script type="module">
    const coordinates = {
      lat: {{ $place->coordinates->latitude }},
      lng: {{ $place->coordinates->longitude }}
    }

    // This variable will hold the marker object.
    var marker = null;

    // Initilize our map.
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmlsbHZvZyIsImEiOiJjbG0zczB6bWcyZnZ3M2xwNjNiOXFnMnJ0In0.b3HHw4P9LUQzwS1fxA8IlQ';
    const map = new mapboxgl.Map({
      container: "{{ $mapId }}",
      style: 'mapbox://styles/mapbox/streets-v12',
      center: coordinates,
      zoom: 10
    });

    // Initialize the marker when map loads
    // and center to it.
    map.on('load', () => {
      createOrUpdateMarker(coordinates);

      map.flyTo({
        center: coordinates
      });
    });

    // Create (or update) a marker at the specified coordinates.
    function createOrUpdateMarker(coordinates) {
      if (marker == null) {
        marker = new mapboxgl.Marker({
          draggable: @json($isMarkerDraggable),
          color: "#F5AC2F",
        }).setLngLat(coordinates).addTo(map);
      } else {
        marker.setLngLat(coordinates);
      }
    }

    window.placeMap = {
      mapboxMap: map,
      createOrUpdateMarker
    }
  </script>
@endPushOnce
