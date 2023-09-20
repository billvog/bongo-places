@extends('layouts.base')

@section('content')
  <div class="space-y-2">
    <h1>Edit photos for:</h1>
    <div>
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
  </div>

  <edit-photos-component upload-photos-modal-id="uploadPhotosModal"
    upload-photos-api-url="{{ route('places.photos.store', $place) }}"
    update-photos-api-url="{{ route('places.photos.update', $place) }}?_method=patch"
    csrf-token="{{ csrf_token() }}" :place='@json($place)'
    :photos='[
        @unless (is_null($place->photos)) @foreach ($place->photos->medially as $image) {id: {{ $image->id }}, order: {{ $image->order }}, file_url: "{{ $image->getSecurePath() }}"}, @endforeach @endunless
    ]'></edit-photos-component>
@endsection

@push('modals')
  {{-- Upload Photos Modal --}}
  <x-modal id="uploadPhotosModal" title="Upload Photos">
    <input type="file" name="file[]" class="filepond" required />
    <div class="pt-4 space-x-4">
      <button id="uploadPhotosSubmitButton" is="custom-button">Upload</button>
      <a href="#" data-micromodal-close>Cancel</a>
    </div>
  </x-modal>
@endpush

@push('javascripts')
  @vite('resources/js/filepond.js')
  @vite('resources/js/micromodal.js')

  <script type="module">
    document.addEventListener('DOMContentLoaded', () => {
      MicroModal.init();
    });

    const uploadPhotosModalId = 'uploadPhotosModal';

    const fileInput = document.querySelector('input[name="file[]"].filepond');

    // Filepond Configuration
    const filepond = Filepond.create(fileInput, {
      labelIdle: `Drag & Drop your photos or <span class="filepond--label-action">Browse</span>`,
      acceptedFileTypes: ["image/*"],
      allowMultiple: true,
      maxFileSize: '10MB',
      imageResizeTargetWidth: 600,
      imageCropAspectRatio: 1,
    });

    filepond.server = {
      url: "{{ route('filepond-server') }}",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    }

    // Handle form submit
    const uploadPhotosSubmitButton =
      document.getElementById('uploadPhotosSubmitButton');

    uploadPhotosSubmitButton.addEventListener('click', () => {
      const fileIds = filepond.getFiles().map(file => {
        return file.serverId
      });

      if (fileIds.length <= 0) {
        console.error('Please select files first.');
        return;
      }

      uploadPhotosSubmitButton.setIsLoading(true);

      fetch("{{ route('places.photos.store', $place) }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            file: fileIds
          })
        })
        .then((response) => {
          if (response.status !== 200) {
            throw new Error("Something went wrong.")
          }

          return response.json()
        })
        .then(data => {
          const actualData = data.data;
          window.onPhotosUploadedCallback(actualData.photos);
          MicroModal.close(uploadPhotosModalId);
        })
        .catch(error => console.error(error))
        .finally(() => {
          uploadPhotosSubmitButton.setIsLoading(false);
        });
    });
  </script>
@endpush
