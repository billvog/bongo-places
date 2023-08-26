@extends('layouts.base')

@section('content')
  <div>
    <h2>Post your place.</h2>
    <div>
      Provide some pictures of your place for your customers to see. <br>
      To make your place publish (hence visiable to others) you need to upload at least one (1) photo.
    </div>
  </div>

  <x-form :action="route('places.photos.store', $place)" method="post" enctype="multipart/form-data">
    <input type="file" name="file[]" class="filepond" required />
    <div class="pt-4 space-x-4">
      <button type="submit">Next</button>
      <a href="{{ route('places.show', $place) }}" class="text-zinc-400">Skip for now</a>
    </div>
  </x-form>
@endsection

@push('javascripts')
  @vite('resources/js/filepond.js')
  <script type="module">
    filepond.server = {
      url: "{{ route('filepond-server') }}",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    }
  </script>
@endpush
