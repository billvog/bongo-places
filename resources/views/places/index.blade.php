@extends('layouts.base')

@section('content')
    <h1>
        Discover places.
    </h1>

    <section>
        <h2 class="mb-4">
            Top-rated.
        </h2>
        <div class="space-y-4">
            @foreach ($places as $place)
                <x-place :place="$place" />
            @endforeach
        </div>
    </section>
@endsection
