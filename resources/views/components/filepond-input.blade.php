<input type="file" name="file[]" class="filepond" required />

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
