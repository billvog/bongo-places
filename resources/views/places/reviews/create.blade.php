@extends('layouts.base')

@section('content')
  <a href="{{ route('places.show', $place) }}">Back to place.</a>

  <h2>Create review for: <u>{{ $place->name }}</u></h2>

  <form action="{{ route('places.reviews.store', $place) }}" method="post" class="flex flex-col space-y-4">
    @include('partials.form.errors')
    @csrf

    <div class="flex flex-col">
      <label for="review_text">Review</label>
      <textarea name="review_text" id="review_text" cols="30" rows="10" placeholder="Write the review here..." required>{{ old('review_text') }}</textarea>
    </div>

    <div class="flex flex-col">
      <label for="rating">Rating</label>
      <div class="flex items-center space-x-2">
        <input type="number" name="rating" id="rating" min="0" max="5" step="0.1"
          value="{{ old('rating', 0) }}" required>
        <div class="text-lg font-bold">/ 5.0</div>
      </div>
    </div>

    <div class="pt-4">
      <button type="submit">Review</button>
    </div>
  </form>
@endsection
