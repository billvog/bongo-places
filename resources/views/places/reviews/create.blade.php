@extends('layouts.base')

@section('content')
  <a href="{{ route('places.show', $place) }}">Back to place.</a>
  <h2>Create review for: <u>{{ $place->name }}</u></h2>
  <form action="{{ route('places.reviews.store', $place) }}" method="post">
    @include('partials.form.errors')
    @csrf
    <textarea name="review_text" id="review_text" cols="30" rows="10" placeholder="Write the review here..." required>{{ old('review_text') }}</textarea>
    <input type="number" name="rating" id="rating" min="0" max="5" step="0.1"
      value="{{ old('rating') }}" required>
    <button type="submit">Review</button>
  </form>
@endsection
