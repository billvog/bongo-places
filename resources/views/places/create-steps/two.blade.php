@extends('layouts.base')

@section('content')
  <div>
    <h2>Post your place.</h2>
    <div>
      Provide some pictures of your place for your customers to see.
    </div>
  </div>

  <x-form :action="route('places.store')" method="post">
    <div class="pt-4">
      <button type="submit">Next</button>
    </div>
  </x-form>
@endsection
