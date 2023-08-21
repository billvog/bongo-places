@props(['place'])

<div>
    <div class="text-lg font-bold">{{ $place->name }}</div>
    <div class="text-sm text-gray-600">{{ Str::limit($place->description, 100, '...') }}</div>
    <div class="font-medium">
        {{ $place->location }}
    </div>
</div>
