<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="referrer" content="no-referrer" />
  <title>Bongo Places // discover and rate places worldwide.</title>

  @vite('resources/css/app.css')
  @stack('styles')

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
</head>

<body>
  <div id="app">
    <header class="pb-[80px]">
      @include('partials.header')
    </header>

    <div class="grid grid-cols-3 gap-8 mx-auto py-8">
      {{-- Left side --}}
      <div>
        @yield('leftSidebar')
      </div>
      {{-- Middle --}}
      <div class="space-y-6">
        @if (Session::has('notice'))
          <div class="text-red-500 font-bold text-lg">
            {{ Session::get('notice') }}
          </div>
        @endif
        @yield('content')
      </div>
      {{-- Right side --}}
      <div>
        @yield('rightSidebar')
      </div>
    </div>
  </div>

  @stack('modals')

  @vite('resources/js/app.js')
  @stack('javascripts')
</body>

</html>
