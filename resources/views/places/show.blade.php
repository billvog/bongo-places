@extends('layouts.base')

@section('content')
  @if (Auth::check() && Auth::user()->id == $place->owner_id)
    <div class="w-fit ml-auto space-x-4">
      <a href="{{ route('places.photos.edit', $place) }}">Edit Photos</a>
      <a href="{{ route('places.edit', $place) }}">Edit</a>
    </div>
  @endif

  <div>
    <div class="mb-4">
      @foreach ($place->medially as $image)
        <img src="{{ $image->file_url }}" alt="Image of {{ $place->name }}" class="w-full h-[400px] object-cover">
      @endforeach
    </div>
    <h2>
      {{ $place->name }}
    </h2>
    <p>
      {{ $place->description }}
    </p>
  </div>
  <hr>
  <div>
    @if ($place->total_reviews_count === 0)
      <div class="space-y-2">
        <div>No reviews yet.</div>
        @auth
          <div class="text-right ml-auto w-[300px]">
            Been there? Share you experience, and
            <a href="{{ route('places.reviews.create', $place) }}">be the first to leave a review</a>.
          </div>
        @endauth
      </div>
    @else
      <div class="flex items-center space-x-4">
        <div class="text-4xl font-bold">
          <span class="text-yellow-400">★</span> {{ number_format($place->average_rating, 1) }} / 5.0
        </div>
        <div class="text-zinc-500 font-medium">
          ({{ $place->total_reviews_count }} people reviewed)
        </div>
      </div>
      <div class="mt-8 space-y-4">
        @if (Auth::check() && !$place->haveReviewed())
          <div>
            Been there? <a href="{{ route('places.reviews.create', $place) }}">Leave a review</a>.
          </div>
        @endif
        @foreach ($place->reviews as $review)
          <x-review :review="$review" />
        @endforeach
      </div>
    @endif
  </div>
@endsection
