<div class="h-[80px] flex justify-center text-lg bg-orange-50 text-orange-400">
  <div class="w-full max-w-xl mx-auto flex justify-between items-center">
    <div class="space-x-4">
      <a href="{{ route('index') }}" class="font-acme text-xl">Bongo Places</a>
      <a href="{{ route('places.index') }}">Discover</a>
    </div>
    <div class="space-x-4">
      @auth
        <div class="flex flex-col items-end">
          <div>
            <a href="" class="text-base">{{ Auth::user()->name }}</a>
          </div>
          <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm px-2.5 py-0.5 hover:no-underline hover:opacity-90">Logout</button>
          </form>
        </div>
      @endauth
      @guest
        <a href="{{ route('auth.login') }}">Login</a>
      @endguest
    </div>
  </div>
</div>
