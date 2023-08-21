<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bongo Places // discover and rate places worldwide.</title>

    @vite('resources/css/app.css')
</head>

<body>

    <header>
        @include('partials.header')
    </header>

    <main class="max-w-xl w-full mx-auto py-8 space-y-6">
        @yield('content')
    </main>

</body>

</html>
