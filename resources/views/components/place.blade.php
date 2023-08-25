@props(['place'])

<div {{ $attributes->merge(['class']) }}>
  <div class="text-lg font-bold">
    <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
  </div>
  <div>
    @if ($place->total_reviews_count === 0)
      No reviews yet.
    @else
      <span class="text-yellow-400">★</span> {{ number_format($place->average_rating, 1) }}
      <span>({{ $place->total_reviews_count }})</span>
    @endif
  </div>
</div>
