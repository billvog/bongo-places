@php
  $tabs = [
      'account.profile' => 'Profile',
      'account.social_accounts' => 'Social Accounts',
  ];
@endphp

@extends('layouts.base')

@section('leftSidebar')
  <div class="h-full flex flex-col items-end space-y-4 pr-8 border-r-2">
    @foreach ($tabs as $tabRoute => $tabName)
      <div>
        <a href="{{ route($tabRoute) }}"
          @if (Route::currentRouteName() == $tabRoute) class="underline text-orange-400" @endif>{{ $tabName }}</a>
      </div>
    @endforeach
  </div>
@endsection

@section('content')
  <h1 class="mb-4">{{ $tabs[Route::currentRouteName()] }}</h1>
  @yield('account.content')
@endsection
