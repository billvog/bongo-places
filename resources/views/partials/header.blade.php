<div class="h-[80px] flex justify-center text-lg bg-orange-50 text-orange-400">
  <div class="w-full max-w-xl mx-auto flex justify-between items-center">
    <div class="space-x-4">
      <a href="{{ route('index') }}">Bongo Places</a>
      <a href="{{ route('places.index') }}">Discover</a>
    </div>
    <div class="space-x-4">
      @if (Auth::check())
        <div class="flex flex-col items-end">
          <div>
            <a href="" class="text-base">{{ Auth::user()->name }}</a>
          </div>
          <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="text-sm font-bold bg-orange-400 text-white px-2.5 py-0.5 rounded-full hover:opacity-90">Logout</button>
          </form>
        </div>
      @else
        <a href="{{ route('auth.login') }}">Join</a>
      @endif
    </div>
  </div>
</div>
