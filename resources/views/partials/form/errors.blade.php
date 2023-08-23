@if ($errors->any())
  <ul class="text-red-600 font-bold">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
@endif
