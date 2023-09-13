@php
  $user = Auth::user();
@endphp

@extends('account.layout')

@section('account.content')
  <div>
    <x-form :action="route('account.profile.update')" method="POST">
      @method('PATCH')

      <div class="flex flex-col">
        <label for="name">Legal Name</label>
        <input name="name" id="name" placeholder="Your legal name" value="{{ old('name', $user->name) }}" required />
      </div>

      <div class="flex flex-col">
        <label>Email</label>
        <input value="{{ $user->email }}" disabled />
      </div>

      <div class="flex flex-col">
        <label for="bio">Bio</label>
        <textarea name="bio" id="bio" cols="30" rows="5" placeholder="Write the some about you...">{{ old('bio', '') }}</textarea>
      </div>

      <div class="pt-4">
        <button type="submit">Update</button>
      </div>
    </x-form>
  </div>
@endsection
