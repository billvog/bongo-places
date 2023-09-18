@php
  $tabs = [
      'account.profile' => 'Profile',
      'account.social_accounts' => 'Social Accounts',
  ];
@endphp

@extends('layouts.base')

@section('leftSidebar')
  <x-sidebarNavigation :tabs="$tabs" />
@endsection

@section('content')
  <h1 class="mb-4">{{ $tabs[Route::currentRouteName()] }}</h1>
  @yield('account.content')
@endsection
