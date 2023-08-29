@extends('layouts.base')

@section('content')
  <div>
    <h2>Post your place.</h2>
    <div>
      Provide name, description and location of your place.
    </div>
  </div>

  <x-form :action="route('places.store')" method="post">
    <div class="flex flex-col">
      <label for="name">Place Name</label>
      <input name="name" id="name" placeholder="A short memorable name of your place" value="{{ old('name') }}"
        required />
    </div>

    <div class="flex flex-col">
      <label for="description">Description</label>
      <textarea name="description" id="description" cols="30" rows="10"
        placeholder="Write the some words about your place here..." required>{{ old('description') }}</textarea>
    </div>

    <div class="flex flex-col">
      <label for="location">Where's that?</label>
      <input name="location" id="location" placeholder="Location of your place" value="{{ old('location') }}" required />
    </div>

    <div class="space-y-2">
      <h3 class="font-bold">Coordinates</h3>
      <div class="flex flex-row space-x-2 text-sm">
        <div class="flex flex-col">
          <label for="coordinates[latitude]">Latitude</label>
          <input type="number" name="coordinates[latitude]" id="coordinates[latitude]"
            value="{{ old('coordinates[latitude]', 0) }}" step="any" required>
        </div>
        <div class="flex flex-col">
          <label for="coordinates[longitude]">Longitude</label>
          <input type="number" name="coordinates[longitude]" id="coordinates[longitude]"
            value="{{ old('coordinates[longitude]', 0) }}" step="any" required>
        </div>
      </div>
      <div class="text-sm text-zinc-500">
        (Used to display your place on the map.)
      </div>
    </div>

    <div class="pt-4">
      <button type="submit">Next</button>
    </div>
  </x-form>
@endsection
