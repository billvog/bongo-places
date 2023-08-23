@extends('layouts.base')

@section('content')
  <div>
    <h2>Reviews for <u>{{ $place->name }}</u></h2>
    <a href="{{ route('places.reviews.create', $place) }}">Write a review.</a>
    <ul>
      @foreach ($reviews as $review)
        <li>
          <a href="{{ route('places.reviews.show', [$place, $review]) }}">{{ $review->review_text }}</a>
        </li>
      @endforeach
    </ul>
  </div>
@endsection
