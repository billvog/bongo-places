@extends('layouts.base')

@section('content')
  <div class="space-y-2">
    <h1>Edit photos for:</h1>
    <div>
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
  </div>

  <div id="updateSuccess" class="text-green-500 font-bold"></div>
  <div id="updateError" class="text-red-500 font-bold"></div>

  <div id="sortable-items" class="flex space-x-2 overflow-x-auto">
    @foreach ($place->medially as $image)
      <div class="cursor-grab">
        <img src="{{ $image->file_url }}" class="h-[100px] w-auto object-cover">
      </div>
    @endforeach
  </div>

  <div>
    <button id="updateButton">Update</button>
  </div>
@endsection

@push('javascripts')
  @vite('resources/js/sortable.js')
  <script type="module">
    const updateSuccess = document.getElementById("updateSuccess");
    const updateError = document.getElementById("updateError");
    const updateButton = document.getElementById("updateButton");

    var images = [
      @foreach ($place->medially as $image)
        {
          id: {{ $image->id }},
          order: {{ $image->order }}
        },
      @endforeach
    ];

    // When Sortablejs notifies us that the ording changed, 
    // update the order in our data and sort the array.
    sortable.options.onChange = (e) => {
      if (e.oldIndex === e.newIndex) return;

      let oldImageOrder = images[e.oldIndex].order;
      images[e.oldIndex].order = images[e.newIndex].order;
      images[e.newIndex].order = oldImageOrder;

      images.sort((a, b) => {
        if (a.order < b.order) return -1;
        if (a.order > b.order) return 1;
        return 0;
      });
    };

    // Make a PATCH request to our endpoint to update the ordering 
    // of the photos.
    updateButton.addEventListener('click', () => {
      updateSuccess.textContent = '';
      updateError.textContent = '';

      fetch(
          "{{ route('places.photos.update', $place) }}?_method=patch", {
            method: 'POST',
            body: JSON.stringify({
              images
            }),
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              "Content-Type": "application/json",
            }
          }
        )
        .then(response => {
          if (response.status == 200) {
            updateSuccess.textContent = "Photos updated."
          } else {
            updateError.textContent = "Something went wrong."
          }
        })
        .catch(() => {
          updateError.textContent = "Something went wrong."
        });
    });
  </script>
@endpush
