@extends('layouts.base')

@push('styles')
  <style>
    .filepond--root {
      width: 200px;
      margin: 0 auto;
    }
  </style>
@endpush

@section('content')
  <div class="space-y-2">
    <h1>Edit logo for:</h1>
    <div>
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
  </div>

  <div class="text-sm">
    <b>NOTE:</b> To make your place publish (hence visiable to others) you need to upload a logo.
  </div>

  <x-form :action="route('places.logo.update', $place)" method="post" enctype="multipart/form-data">
    @method('patch')
    <input type="file" name="file" class="filepond" required />
    <div class="pt-4 space-x-4">
      <button type="submit">Update</button>
    </div>
  </x-form>
@endsection

@push('javascripts')
  @vite('resources/js/filepond.js')
  <script type="module">
    const fileInput = document.querySelector('input[name="file"].filepond');
    const myFilepond = filepond.create(fileInput, {
      labelIdle: `Drag & Drop your logo or <span class="filepond--label-action">Browse</span>`,
      acceptedFileTypes: ["image/*"],
      maxFileSize: '5MB',
      imagePreviewHeight: 170,
      imageCropAspectRatio: '1:1',
      imageResizeTargetWidth: 200,
      imageResizeTargetHeight: 200,
      stylePanelLayout: 'compact circle',
      styleLoadIndicatorPosition: 'center bottom',
      styleProgressIndicatorPosition: 'right bottom',
      styleButtonRemoveItemPosition: 'left bottom',
      styleButtonProcessItemPosition: 'right bottom',
    });

    myFilepond.server = {
      url: "{{ route('filepond-server') }}",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    }
  </script>
@endpush
