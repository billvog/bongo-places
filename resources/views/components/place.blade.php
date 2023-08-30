@props(['place'])

<div {{ $attributes->merge(['class' => 'group flex flex-col bg-orange-50 rounded-xl']) }}>
  <div class="flex-1 relative">
    {{-- First photo --}}
    <div
      class="rounded-t-xl h-[200px] object-cover bg-black bg-center bg-[length:110%] group-hover:bg-[length:115%] transition-all"
      style='background-image: url({{ $place->medially->first()?->file_url ?? null }})'>
    </div>
    {{-- Logo --}}
    <img src="{{ $place->logo()->exists() ? $place->logo->getSecurePath() : 'https://placehold.co/100x100' }}"
      alt='Logo for "{{ $place->name }}"'
      class="w-16 h-16 group-hover:scale-110 transition-transform object-cover rounded-full absolute left-4 -bottom-4 border-2 border-orange-50">
  </div>
  <div class="px-4 pt-5 pb-3">
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
