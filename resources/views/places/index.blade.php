@extends('layouts.base')

@section('content')
  <h1>
    Discover places.
  </h1>

  <section>
    <div class="grid grid-cols-2 grid-rows-2 gap-4">
      @foreach ($places as $place)
        <x-place :place="$place" />
      @endforeach
    </div>
  </section>
@endsection
