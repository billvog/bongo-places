@extends('layouts.base')

@section('content')
  <div class="space-y-2">
    <h1>Upload photos for:</h1>
    <div>
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
  </div>

  <div class="text-sm">
    <b>NOTE:</b> To make your place publish (hence visiable to others) you need to upload at least one (1) photo.
  </div>

  <x-form :action="route('places.photos.store', $place)" method="post" enctype="multipart/form-data">
    <input type="file" name="file[]" class="filepond" required />
    <div class="pt-4 space-x-4">
      <button type="submit">Upload</button>
      <a href="{{ route('places.photos.edit', $place) }}">Edit existing photos</a>
    </div>
  </x-form>
@endsection

@push('javascripts')
  @vite('resources/js/filepond.js')
  <script type="module">
    const fileInput = document.querySelector('input[name="file[]"].filepond');
    const myFilepond = filepond.create(fileInput, {
      labelIdle: `Drag & Drop your photos or <span class="filepond--label-action">Browse</span>`,
      acceptedFileTypes: ["image/*"],
      allowMultiple: true,
      maxFileSize: '10MB',
      imageResizeTargetWidth: 600,
      imageCropAspectRatio: 1,
    });

    myFilepond.server = {
      url: "{{ route('filepond-server') }}",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    }
  </script>
@endpush
