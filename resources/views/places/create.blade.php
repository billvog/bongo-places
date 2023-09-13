@extends('layouts.base')

@section('content')
  <div>
    <h2>Post your place.</h2>
    <div>
      Provide the name and description of your place.
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
        placeholder="Write some words about your place here..." required>{{ old('description') }}</textarea>
    </div>

    <div class="pt-4">
      <button type="submit">Next</button>
    </div>
  </x-form>
@endsection
