@extends('layouts.base')

@section('content')
  <div class="space-y-2">
    <h1>Edit photos for:</h1>
    <div>
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
  </div>

  <edit-photos-component upload-photos-url="{{ route('places.photos.create', $place) }}"
    update-photos-api-url="{{ route('places.photos.update', $place) }}?_method=patch" csrf-token="{{ csrf_token() }}"
    :place='@json($place)'
    :photos='[
        @unless (is_null($place->photos)) @foreach ($place->photos->medially as $image) {id: {{ $image->id }}, order: {{ $image->order }}, file_url: "{{ $image->getSecurePath() }}"}, @endforeach @endunless
    ]'></edit-photos-component>
@endsection
