@props(['tabs'])

<div class="h-full flex flex-col items-end space-y-4 border-r-4">
  @foreach ($tabs as $tabRoute => $tabName)
    <div class="relative">
      <div
        class="pr-8 @if (Route::currentRouteName() == $tabRoute) after:absolute after:top-0 after:bottom-0 after:-right-1 after:w-1 after:bg-orange-400 after:border-t-4 after:border-b-4 after:border-orange-50 @endif">
        <a href="{{ route($tabRoute) }}">{{ $tabName }}</a>
      </div>
    </div>
  @endforeach
</div>
