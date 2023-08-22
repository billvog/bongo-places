@props(['place'])

<div {{ $attributes->merge(['class']) }}>
  <div class="text-lg font-bold">
    <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
  </div>
  <div class="text-sm text-gray-600">{{ Str::limit($place->description, 100, '...') }}</div>
  <div class="font-medium">
    {{ $place->location }}
  </div>
</div>
