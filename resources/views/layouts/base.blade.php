<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bongo Places // discover and rate places worldwide.</title>

  @vite('resources/css/app.css')

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
</head>

<body>

  <header>
    @include('partials.header')
  </header>

  <main class="max-w-xl w-full mx-auto py-8 space-y-6">
    @if (Session::has('notice'))
      <div class="text-red-500 font-bold text-lg">
        {{ Session::get('notice') }}
      </div>
    @endif

    @yield('content')
  </main>

  @stack('javascripts')
</body>

</html>
