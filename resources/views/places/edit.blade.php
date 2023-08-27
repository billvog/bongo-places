@extends('layouts.base')

@section('content')
  <div class="space-y-2">
    <h1>Edit:</h1>
    <div>
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
  </div>

  <x-form :action="route('places.update', $place)" method="post">
    @method('patch')

    <div class="flex flex-col">
      <label for="name">Place Name</label>
      <input name="name" id="name" placeholder="A short memorable name of your place"
        value="{{ old('name', $place->name) }}" required />
    </div>

    <div class="flex flex-col">
      <label for="description">Description</label>
      <textarea name="description" id="description" cols="30" rows="10"
        placeholder="Write the some words about your place here..." required>{{ old('description', $place->description) }}</textarea>
    </div>

    <div class="flex flex-col">
      <label for="location">Where's that?</label>
      <input name="location" id="location" placeholder="Location of your place"
        value="{{ old('location', $place->location) }}" required />
    </div>

    <div class="space-y-2">
      <h3 class="font-bold">Coordinates</h3>
      <div class="flex flex-row space-x-2 text-sm">
        <div class="flex flex-col">
          <label for="coordinates[latitude]">Latitude</label>
          <input type="number" name="coordinates[latitude]" id="coordinates[latitude]"
            value="{{ old('coordinates[latitude]', $place->coordinates->latitude) }}" step="any" required>
        </div>
        <div class="flex flex-col">
          <label for="coordinates[longitude]">Longitude</label>
          <input type="number" name="coordinates[longitude]" id="coordinates[longitude]"
            value="{{ old('coordinates[longitude]', $place->coordinates->longitude) }}" step="any" required>
        </div>
      </div>
      <div class="text-sm text-zinc-500">
        (Used to display your place on the map.)
      </div>
    </div>

    <div class="flex flex-col space-y-2">
      <label for="status">Status</label>
      <select name="status" id="status">
        <option value="draft" @selected(old('status', $place->status->value) == 'draft')>Draft</option>
        <option value="published" @selected(old('status', $place->status->value) == 'published')>Published</option>
      </select>
      <div class="text-sm text-zinc-500">
        Publishing your place makes it visible to everyone.
      </div>
    </div>

    <div class="pt-4">
      <button type="submit">Update</button>
    </div>
  </x-form>
@endsection
