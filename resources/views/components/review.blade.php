@props(['review'])

<div class="px-6 py-4">
  <div class="flex space-x-2">
    <div class="flex space-x-2 group">
      @if ($review->reviewer->avatar_url)
        <img src="{{ $review->reviewer->avatar_url }}" alt="" class="w-6 h-6 object-cover rounded-md">
      @endif
      <b class="group-hover:underline cursor-default">{{ $review->reviewer->name }}</b>
    </div>
    <div class="text-yellow-400 font-bold">
      ★ {{ number_format($review->rating, 1) }}
    </div>
  </div>
  <div class="mt-1.5">
    {{ $review->review_text }}
  </div>
  @if (Auth::check() && Auth::user()->id === $review->reviewer_id)
    <div class="mt-3">
      <a href="#">Edit</a>
    </div>
  @endif
</div>
