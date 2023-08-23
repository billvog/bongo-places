@extends('layouts.base')

@section('content')
  <div>
    <x-place class="pb-4" :place="$place" />
    <a href="{{ route('places.reviews.index', $place) }}">
      View reviews.
    </a>
  </div>
@endsection
