@extends('layouts.base')

@section('content')
  @if (Auth::check() && Auth::user()->id == $place->owner_id)
    <div class="w-fit ml-auto space-x-4">
      <a href="{{ route('places.photos.edit', $place) }}">Edit Photos</a>
      <a href="{{ route('places.edit', $place) }}">Edit</a>
    </div>
  @endif
  <div class="space-y-4">
    <div class="flex items-center space-x-4">
      <div class="relative group">
        <img src="{{ $place->hasLogo() ? $place->logo->getSecureUrl() : '' }}" alt="{{ $place->name }}'s logo"
          class="w-20 h-20 object-cover rounded-full">
        @if (Auth::check() && Auth::user()->id == $place->owner_id)
          <div
            class="absolute top-0 bottom-0 left-0 right-0 w-full h-full rounded-full flex justify-center items-center opacity-0 group-hover:opacity-100 backdrop-filter backdrop-blur-[2px] bg-black bg-opacity-5 transition-all">
            <a href="{{ route('places.logo.edit', $place) }}">Edit</a>
          </div>
        @endif
      </div>
      <h2>
        {{ $place->name }}
      </h2>
    </div>

    @unless (is_null($place->photos))
      <x-swiper-carousel :images="$place->photos->medially" class="h-[500px] rounded-xl mb-4"></x-swiper-carousel>
    @endunless

    <div>
      {{ $place->description }}
    </div>
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
          <span class="text-yellow-400">★</span> {{ number_format($place->average_rating, 1) }} <span
            class="text-yellow-400">/ 5</span>
        </div>
        <div class="text-zinc-400 font-medium">
          ({{ $place->total_reviews_count }} reviews)
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

@section('rightSidebar')
  {{-- Owner details --}}
  <div class="max-w-sm w-fit bg-orange-100 rounded-xl px-8 py-6 space-y-4">
    <div class="font-bold">
      Meet the owner
    </div>
    <div class="flex flex-row items-center space-x-4">
      <img src="{{ $place->owner->avatar_url }}" class="w-16 h-16 object-cover rounded-2xl">
      <div class="flex flex-col">
        <div class="font-bold">
          {{ $place->owner->name }}
        </div>
        <div class="text-orange-400 text-sm">
          (+49) 478-274-2653
        </div>
      </div>
    </div>
    <div class="text-sm">
      <b>Joined at</b> <br>
      {{ $place->owner->created_at->format('M d, Y') }}
    </div>
    <div class="text-sm">
      <b>About</b> <br>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non doloribus aperiam, magni deserunt ipsam quasi
      consequuntur dolore omnis, recusandae ipsum ducimus hic voluptas possimus quaerat porro nemo, consequatur
      perferendis facere?
    </div>
  </div>
@endsection
