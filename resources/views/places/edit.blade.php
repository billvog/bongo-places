@extends('layouts.base')

@section('content')
  <div class="space-y-2">
    <h1>Edit:</h1>
    <div>
      <a href="{{ route('places.show', $place) }}">{{ $place->name }}</a>
    </div>
  </div>

  <hr>

  <div>
    <div class="flex items-center space-x-2">
      <div class="text-lg font-bold">
        Location
      </div>
      <div>
        <a href="{{ route('places.location.edit', $place) }}" class="text-sm text-orange-400">Edit</a>
      </div>
    </div>
    <div>
      {{ $place->location }}
    </div>
  </div>

  <hr>

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
