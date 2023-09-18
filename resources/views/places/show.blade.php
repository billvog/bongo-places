@extends('layouts.base')

@section('content')
  {{-- Header --}}
  @if (Auth::check() && Auth::user()->id == $place->owner_id)
    <div class="w-fit ml-auto space-x-4">
      <a href="{{ route('places.photos.edit', $place) }}">Edit Photos</a>
      <a href="{{ route('places.edit', $place) }}">Edit</a>
    </div>
  @endif

  <div class="space-y-4">
    <div class="flex items-center space-x-4">
      {{-- Logo --}}
      @if ($place->hasLogo())
        <div class="relative group">
          <img src="{{ $place->logo->getSecureUrl() }}" alt="{{ $place->name }}'s logo"
            class="w-20 h-20 object-cover rounded-full">
          @if (Auth::check() && Auth::user()->id == $place->owner_id)
            <div
              class="absolute top-0 bottom-0 left-0 right-0 w-full h-full rounded-full flex justify-center items-center opacity-0 group-hover:opacity-100 backdrop-filter backdrop-blur-[2px] bg-black bg-opacity-5 transition-all">
              <a href="{{ route('places.logo.edit', $place) }}">Edit</a>
            </div>
          @endif
        </div>
      @else
        <a href="{{ route('places.logo.edit', $place) }}" title="Add logo" class="hover:no-underline">
          <div
            class="flex justify-center items-center w-20 h-20 rounded-full bg-orange-200 bg-opacity-50 hover:bg-opacity-70 text-orange-600 text-3xl font-normal">
            +
          </div>
        </a>
      @endif
      <div class="flex flex-col space-y-1">
        {{-- Place name --}}
        <h2>
          {{ $place->name }}
        </h2>
        <div class="flex divider-x text-base">
          {{-- Rating --}}
          <div>
            @if ($place->total_reviews_count === 0)
              <div>
                No reviews yet.
              </div>
            @else
              <div class="text-yellow-400 font-bold">
                <span>★</span> {{ $place->average_rating }}
              </div>
            @endif
          </div>
          {{-- Location --}}
          <div>
            <a href="javascript:openMap();" class="link">
              {{ $place->location }}
            </a>
          </div>
        </div>
      </div>
    </div>

    @unless (is_null($place->photos))
      <x-swiper-carousel :images="$place->photos->medially" class="h-[500px] rounded-xl mb-4"></x-swiper-carousel>
    @endunless

    <div>
      {{ $place->description }}
    </div>
  </div>

  <x-spacer value="2" />

  {{-- Review Section --}}
  <div class="bg-orange-100 px-8 py-6">
    @if ($place->total_reviews_count === 0)
      <div class="space-y-2">
        <div class="text-2xl font-bold">No reviews yet.</div>
        @auth
          <div class="text-right ml-auto w-[300px]">
            Been there? Share you experience, and
            <a href="{{ route('places.reviews.create', $place) }}">be the first to leave a review</a>.
          </div>
        @endauth
      </div>
    @else
      <div class="flex items-center leading-tight space-x-4 text-4xl font-bold">
        <div class="text-black">
          Reviews
        </div>
        <div class="font-acme text-orange-300">
          {{ $place->total_reviews_count }}
        </div>
      </div>
      <div class="mt-8 divider-y divide-orange-200">
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

@push('modals')
  <x-modal id="placeMapModal" :title="$place->location">
    {{-- Open in Google Map link --}}
    <div class="pb-8">
      <a href="http://www.google.com/maps/place/{{ $place->coordinates->latitude }},{{ $place->coordinates->longitude }}"
        target="blank" class="link link-ext">Open
        in Google Maps</a>
    </div>
    {{-- Mapbox Map --}}
    <x-place.locationMap :place="$place" />
  </x-modal>
@endpush

@push('javascripts')
  @vite('resources/js/micromodal.js')
  <script>
    function openMap() {
      MicroModal.show('placeMapModal');
    }

    document.addEventListener('DOMContentLoaded', () => {
      MicroModal.init();
    });
  </script>
@endpush
