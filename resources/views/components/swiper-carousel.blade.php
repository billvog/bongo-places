@props(['images', 'zoomOnHover' => false])

@pushOnce('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
@endPushOnce

<div {{ $attributes->merge(['class' => 'swiper group']) }}>
  <div class="swiper-wrapper">
    @foreach ($images as $image)
      <div class="swiper-slide relative">
        @if ($zoomOnHover)
          <div
            class="absolute top-0 bottom-0 left-0 right-0 w-full h-full bg-center bg-cover filter blur-xl scale-110 z-0"
            style='background-image: url({{ $image->file_url ?? null }})'>
          </div>
        @endif
        <div
          class="absolute top-0 bottom-0 left-0 right-0 w-full h-full bg-center bg-no-repeat @if ($zoomOnHover) bg-[length:110%] group-hover:bg-[length:115%] transition-all z-10 @else bg-cover @endif"
          style='background-image: url({{ $image->file_url ?? null }})'>
        </div>
      </div>
    @endforeach
  </div>
  <div class="swiper-controls opacity-0 group-hover:opacity-100">
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  </div>
</div>

@pushOnce('javascripts')
  <script type="module">
    import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.mjs'

    const swiper = new Swiper('.swiper', {
      direction: 'horizontal',
      loop: true,

      // If we need pagination
      pagination: {
        el: '.swiper-pagination',
      },

      // Navigation arrows
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    })
  </script>
@endPushOnce
