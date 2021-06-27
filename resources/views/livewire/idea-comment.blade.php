<div class="comment-container relative bg-white rounded-xl flex mt-4">
  <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
    <div class="flex-none">
      <a href="#">
        <img src="{{ $comment->user->getAvatar() }}" class="w-14 h-14 rounded-xl" alt="avatar">
      </a>
    </div>
    <div class="w-full md:mx-4">
      {{-- <h4 class="text-xl font-semibold">
        <a href="#" class="hover:underline">Yet another random title can go here!</a>
      </h4> --}}
      <div class="text-gray-600 line-clamp-3">
        {{ $comment->body }}
      </div>

      <div class="flex items-center justify-between mt-6">
        <div class="flex items-center text-xxs text-gray-400 font-semibold space-x-2">
          <div class="font-bold text-gray-900">{{ $comment->user->name }}</div>
          <div>&bull;</div>
          <div>{{ $comment->created_at->diffForHumans() }}</div>
        </div>

        <div x-data="{ isOpen: false }" class="flex items-center space-x-2 relative">
          <button @click="isOpen = !isOpen" class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in px-4 py-2">
            <svg fill="currentColor" width="24" height="6">
              <path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z">
              </path>
            </svg>
          </button>
          <ul x-cloak x-show.transition.origin.top.left="isOpen" @click.away="isOpen = false" @keydown.escape.window="isOpen = false" class="idea-dialog absolute text-left w-44 font-semibold bg-white shadow-dialog rounded-xl z-10 py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0">
            <li><a href="#" class="hover:bg-gray-100 block px-5 py-3 transition duration-150 ease-in">Mark as Spam</a></li>
            <li><a href="#" class="hover:bg-gray-100 block px-5 py-3 transition duration-150 ease-in">Delete Post</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
