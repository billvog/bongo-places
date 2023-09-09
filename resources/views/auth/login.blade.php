@extends('layouts.base')

@section('content')
  <h1>
    Login
  </h1>

  <div>We only allow login with trusty Third-Parties.</div>

  <div>
    <div>
      <a href="{{ route('auth.redirect', 'google') }}" class="flex w-fit space-x-2">
        <img src="{{ asset('storage/oath-providers/google.svg') }}" alt="Google Logo">
        <span>Sign in with Google</span>
      </a>
    </div>
  </div>
@endsection
