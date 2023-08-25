@extends('layouts.base')

@section('content')
  <h1>
    Login
  </h1>

  <div>
    <a href="{{ route('auth.google.redirect') }}">Login with Google</a>
  </div>
@endsection
