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
    <b>NOTE:</b> To make your place published (hence visiable to others) you need
    to
    upload a logo.
  </div>

  <x-form id="updateLogoForm" :action="route('places.logo.update', $place)" method="post"
    enctype="multipart/form-data">
    @method('patch')
    <input type="file" name="file" class="filepond" required />
    <div class="pt-4 space-x-4">
      <button type="submit">Update</button>
    </div>
    <div id="updateLogoFormError" class="text-red-500 font-bold"></div>
  </x-form>
@endsection

@push('javascripts')
  @vite('resources/js/filepond.js')
  <script type="module">
    // Configure Filepond
    const fileInput = document.querySelector('input[name="file"].filepond');
    const filepond = Filepond.create(fileInput, {
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
      files: [
        @if ($place->hasLogo())
          {
            source: '{{ $place->logo->getSecureUrl() }}',
            options: {
              type: 'local'
            }
          }
        @endif ()
      ],
      server: {
        url: "{{ route('filepond-server') }}",
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        load: (imageUrl, load) => {
          fetch(imageUrl)
            .then(res => res.blob())
            .then(load);
        },
      }
    });

    const updateLogoForm = document.getElementById('updateLogoForm');
    const updateLogoFormError = document.getElementById('updateLogoFormError');

    // Check if user has uploaded a file
    // before submitting the form.
    const canUpdateLogoFormSubmit = () => {
      updateLogoFormError.textContent = '';

      // Get current loaded file from Filepond.
      const logoFile = filepond.getFile();

      // Check if it is null, meaning that there 
      // isn't a loaded file.
      if (logoFile == null) {
        updateLogoFormError.textContent =
          'Please select a photo first.';
        return false;
      }

      // Check the origin of the file. `INPUT` 
      // means that the user selected it. We 
      // do that because if the Place has a
      // logo already it gets loaded in startup.
      // The existing logo has an origin of `LOCAL`.
      // See Filepond docs for that.
      if (logoFile.origin !== Filepond.FileOrigin.INPUT) {
        updateLogoFormError.textContent =
          'Please upload another logo if you wish to update it.';
        return false;
      }

      // Check if Filepond is ready, meaning 
      // that if a logo is chosen it is uploaded.
      if (filepond.status !== Filepond.Status.READY) {
        updateLogoFormError.textContent =
          'Please wait until the logo is uploaded.';
        return false;
      }

      // In every other case, the form is good,
      // so we can submit.
      return true;
    }

    updateLogoForm.addEventListener('submit', (event) => {
      if (canUpdateLogoFormSubmit() === false) {
        event.preventDefault();
      }
    })
  </script>
@endpush
