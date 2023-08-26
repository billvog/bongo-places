@props(['place'])

<div {{ $attributes->merge(['class' => 'bg-orange-50 rounded-xl']) }}>
  <div>
    <img src="{{ $place->medially->first()->file_url }}" class="rounded-t-xl">
  </div>
  <div class="px-4 py-3">
    <div class="text-base font-bold">
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
    <div class="text-sm">
      @if ($place->total_reviews_count === 0)
        No reviews yet.
      @else
        <span class="text-yellow-400">★</span> {{ number_format($place->average_rating, 1) }}
        <span>({{ $place->total_reviews_count }})</span>
      @endif
    </div>
  </div>
</div>
