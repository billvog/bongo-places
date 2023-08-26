<form {{ $attributes }} class="flex flex-col space-y-4">
  @include('partials.form.errors')
  @csrf

  {{ $slot }}

</form>
