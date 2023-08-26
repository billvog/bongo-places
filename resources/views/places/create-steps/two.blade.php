@extends('layouts.base')

@section('content')
  <div>
    <h2>Post your place.</h2>
    <div>
      Provide some pictures of your place for your customers to see.
    </div>
  </div>

  <x-form :action="route('places.photos.store', $place)" method="post" enctype="multipart/form-data">
    <input type="file" name="file[]" class="filepond" required />
    <div class="pt-4">
      <button type="submit">Next</button>
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
