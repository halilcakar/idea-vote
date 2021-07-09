@props([
  'event-to-open-modal' => null,
  'livewire-event-to-open-modal' => null,
  'event-to-close-modal',
  'modal-title',
  'modal-description',
  'modal-confirm-button-text',
  'wire-click',
])
<div
  x-cloak
  x-show="isOpen"
  x-data="{ isOpen: false }"
  @keydown.escape.window="isOpen = false"
  @isset ($eventToOpenModal)
  {{ '@'.$eventToOpenModal }}.window="
    isOpen = true;
    $nextTick(() => $refs.button.focus());
  "
  @endif
  x-init="
    Livewire.on('{{ $eventToCloseModal }}', () => isOpen = false)

    @isset($livewireEventToOpenModal)
      Livewire.on('{{ $livewireEventToOpenModal }}', () => {
        isOpen = true;
        $nextTick(() => $refs.button.focus());
      })
    @endif
  "
  class="fixed inset-0 z-20 overflow-y-auto"
  aria-labelledby="modal-title"
  role="dialog" aria-modal="true"
>
  <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

    <div
      x-show.transition.opacity.duration.300ms="isOpen"
      class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
      aria-hidden="true"
    ></div>

    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div
      @click.away="isOpen = false"
      x-show.transition.opacity.duration.300ms="isOpen"
      class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
    >
      <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
            <svg class="w-6 h-6 text-red" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
              {{ $modalTitle }}
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                {{ $modalDescription }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
        <button x-ref="button" wire:click="{{ $wireClick }}" type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm bg-blue hover:bg-blue-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue sm:ml-3 sm:w-auto sm:text-sm">
          {{ $modalConfirmButtonText }}
        </button>
        <button @click="isOpen=false;" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>
