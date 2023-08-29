@props(['place'])

<div {{ $attributes->merge(['class' => 'flex flex-col bg-orange-50 rounded-xl']) }}>
  <div class="flex-1">
    <img src="{{ $place->medially->first()?->file_url ?? null }}" class="rounded-t-xl h-full bg-black">
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
