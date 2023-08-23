@extends('layouts.base')

@section('content')
  <div>
    <a href="{{ route('places.show', $place) }}">Back to place.</a>
    <h2>Review for <u>{{ $place->name }}</u></h2>
    <div>
      {{ $review->review_text }}
    </div>
    <div>
      {{ $review->rating }} / 5
    </div>
  </div>
@endsection
