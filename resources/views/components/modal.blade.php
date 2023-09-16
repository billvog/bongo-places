@props(['id', 'title'])

<div class="modal" id="{{ $id }}" aria-hidden="true">
  <div
    class="fixed z-50 top-0 bottom-0 left-0 right-0 bg-black bg-opacity-20 flex justify-center items-center backdrop-blur-sm"
    tabindex="-1">
    <div class="bg-orange-50 px-8 py-6 w-full max-w-xl max-h-screen rounded-xl overflow-y-auto box-border space-y-6"
      role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title">
      <header class="flex justify-between items-center">
        <h2 id="{{ $id }}-title">
          {{ $title }}
        </h2>
        <div data-micromodal-close title="Close" class="font-bold text-red-600 cursor-pointer">
          <x-icons.x-mark />
        </div>
      </header>
      <main id="{{ $id }}-content">
        {{ $slot }}
      </main>
    </div>
  </div>
</div>
