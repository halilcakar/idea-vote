<div class="relative flex mt-4 transition duration-500 ease-in bg-white comment-container rounded-xl">
  <div class="flex flex-col flex-1 px-4 py-6 md:flex-row">
    <div class="flex-none">
      <a href="#">
        <img src="{{ $comment->user->getAvatar() }}" class="w-14 h-14 rounded-xl" alt="avatar">
      </a>
    </div>
    <div class="w-full md:mx-4">
      <div class="text-gray-600">
        @admin($comment->spam_reports > 0)
          <div class="mb-2 text-red">Spam Reports: {{ $comment->spam_reports }}</div>
        @endadmin
        {{ $comment->body }}
      </div>

      <div class="flex items-center justify-between mt-6">
        <div class="flex items-center space-x-2 font-semibold text-gray-400 text-xxs">
          <div class="font-bold text-gray-900">{{ $comment->user->name }}</div>
          @if ($ideaUserId == $comment->user->id)
          <div>&bull;</div>
          <div class="px-3 py-1 bg-gray-100 border rounded-full">OP</div>
          @endif
          <div>&bull;</div>
          <div>{{ $comment->created_at->diffForHumans() }}</div>
        </div>

        @auth
          <div x-data="{ isOpen: false }" class="relative flex items-center space-x-2">
            <button @click="isOpen = !isOpen" class="relative px-4 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7">
              <svg fill="currentColor" width="24" height="6">
                <path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z">
                </path>
              </svg>
            </button>
            <ul x-cloak x-show.transition.origin.top.left="isOpen" @click.away="isOpen = false" @keydown.escape.window="isOpen = false" class="absolute right-0 z-10 py-3 font-semibold text-left bg-white idea-dialog w-44 shadow-dialog rounded-xl md:ml-8 top-8 md:top-6 md:left-0">
              @can('update', $comment)
              <li>
                <a
                  href="#"
                  @click.prevent="
                    isOpen=false;
                    Livewire.emit('setEditComment', {{ $comment->id }})
                  "
                  class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100"
                >
                  Edit Comment
                </a>
              </li>
              @endcan
              @can('delete', $comment)
              <li>
                <a
                  href="#"
                  @click.prevent="
                    isOpen=false;
                    Livewire.emit('setDeleteComment', {{ $comment->id }})
                  "
                  class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100"
                >
                  Delete Comment
                </a>
              </li>
              @endcan
              <li>
                <a
                  href="#"
                  @click.prevent="
                      isOpen = false
                      Livewire.emit('setMarkAsSpamComment', {{ $comment->id }})
                  "
                  class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100"
                >
                  Mark as Spam
                </a>
              </li>

              @admin($comment->spam_reports > 0)
              <li>
                <a
                  href="#"
                  @click.prevent="
                      isOpen = false
                      Livewire.emit('setMarkAsNotSpamComment', {{ $comment->id }})
                  "
                  class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100"
                >
                  Not Spam
                </a>
              </li>
              @endadmin
            </ul>
          </div>
        @endauth
      </div>
    </div>
  </div>
</div>
