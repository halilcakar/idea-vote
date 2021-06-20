<x-app-layout>
    <div class="filters flex space-x-6">
        <div class="w-1/3">
            <select name="category" id="category" class="w-full rounded-xl border-none px-4 py-2">
                <option value="Category One">Category One</option>
                <option value="Category Two">Category Two</option>
                <option value="Category Three">Category Three</option>
                <option value="Category Four">Category Four</option>
            </select>
        </div>

        <div class="w-1/3">
            <select name="other_filters" id="other_filters" class="w-full rounded-xl border-none px-4 py-2">
                <option value="Filter One">Filter One</option>
                <option value="Filter Two">Filter Two</option>
                <option value="Filter Three">Filter Three</option>
                <option value="Filter Four">Filter Four</option>
            </select>
        </div>

        <div class="w-2/3 relative">
            <input type="search" placeholder="Find an idea"
                   class="w-full rounded-xl bg-white border-none placeholder-gray-900 px-4 py-2 pl-8">
            <div class="absolute top-0 flex items-center h-full ml-2">
                <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div> {{-- end filters --}}

    <div class="ideas-container space-y-6 py-6">
        <div class="idea-container cursor-pointer bg-white rounded-xl flex hover:shadow-card transition duration-150 ease-in">
            <div class="border-r border-gray-100 px-5 py-8">
                <div class="text-center">
                    <div class="font-semibold text-2xl">12</div>
                    <div class="text-gray-500">Votes</div>
                </div>

                <div class="mt-8">
                    <button class="w-20 bg-gray-200 font-bold text-xxs uppercase rounded-xl px-4 py-3 border border-gray-200 hover:border-gray-400 transition duration-150 ease-in">Vote</button>
                </div>
            </div>

            <div class="flex px-2 py-6">
                <a href="#" class="flex-none">
                    <img src="https://source.unsplash.com/200x200/?face&crop=face" class="w-14 h-14 rounded-xl" alt="avatar">
                </a>
                <div class="mx-4">
                    <h4 class="text-xl font-semibold">
                        <a href="#" class="hover:underline">Yet another random title can go here!</a>
                    </h4>
                    <div class="text-gray-600 mt-3 line-clamp-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, veniam perspiciatis. Laborum amet, iste nemo incidunt itaque vitae voluptatum doloremque alias fuga quasi facere exercitationem, quis architecto provident minus aut fugit at laboriosam? Corrupti doloribus ullam repellat reprehenderit nisi? Dolor optio rem quidem magni perferendis ducimus quis nisi necessitatibus minima libero? Omnis ipsam id facilis aliquid pariatur. Earum ab officiis asperiores velit ipsa minima eum sequi assumenda aliquam deserunt ex, veniam odio optio porro quae, consequuntur possimus nostrum tenetur illum aliquid ea! Fuga vel voluptatibus excepturi doloribus asperiores? Obcaecati, possimus quidem? Nam reprehenderit enim animi culpa magni neque dignissimos assumenda!
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-xs font-semibold space-x-2 text-gray-400">
                            <div>10 hours ago</div>
                            <div>&bull;</div>
                            <div>Category One</div>
                            <div>&bull;</div>
                            <div class="text-gray-900">3 Comments</div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="relative bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 px-4 py-2">Open</div>

                            <button class="bg-gray-100 hover:bg-gray-200 rounded-full h-7 transition duration-150 ease-in px-4 py-2">
                                <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"></svg>

                                <ul class="idea-dialog absolute text-left w-44 font-semibold bg-white shadow-dialog rounded-xl py-2 ml-8">
                                    <li><a href="#" class="hover:bg-gray-100 block px-5 py-3 transition duration-150 ease-in">Mark as Spam</a></li>
                                    <li><a href="#" class="hover:bg-gray-100 block px-5 py-3 transition duration-150 ease-in">Delete Post</a></li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="idea-container cursor-pointer bg-white rounded-xl flex hover:shadow-card transition duration-150 ease-in">
            <div class="border-r border-gray-100 px-5 py-8">
                <div class="text-center">
                    <div class="font-semibold text-2xl text-blue">66</div>
                    <div class="text-gray-500">Votes</div>
                </div>

                <div class="mt-8">
                    <button class="w-20 bg-gray-200 font-bold text-xxs uppercase rounded-xl px-4 py-3 border border-gray-200 hover:border-gray-400 transition duration-150 ease-in text-blue">Voted</button>
                </div>
            </div>

            <div class="flex px-2 py-6">
                <a href="#" class="flex-none">
                    <img src="https://source.unsplash.com/200x200/?face&crop=face" class="w-14 h-14 rounded-xl" alt="avatar">
                </a>
                <div class="mx-4">
                    <h4 class="text-xl font-semibold">
                        <a href="#" class="hover:underline">A random title can go here!</a>
                    </h4>
                    <div class="text-gray-600 mt-3 line-clamp-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, veniam perspiciatis. Laborum amet, iste nemo incidunt itaque vitae voluptatum doloremque alias fuga quasi facere exercitationem, quis architecto provident minus aut fugit at laboriosam? Corrupti doloribus ullam repellat reprehenderit nisi? Dolor optio rem quidem magni perferendis ducimus quis nisi necessitatibus minima libero? Omnis ipsam id facilis aliquid pariatur. Earum ab officiis asperiores velit ipsa minima eum sequi assumenda aliquam deserunt ex, veniam odio optio porro quae, consequuntur possimus nostrum tenetur illum aliquid ea! Fuga vel voluptatibus excepturi doloribus asperiores? Obcaecati, possimus quidem? Nam reprehenderit enim animi culpa magni neque dignissimos assumenda!
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-xs font-semibold space-x-2 text-gray-400">
                            <div>10 hours ago</div>
                            <div>&bull;</div>
                            <div>Category One</div>
                            <div>&bull;</div>
                            <div class="text-gray-900">3 Comments</div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="relative bg-yellow text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 px-4 py-2">In Progress</div>

                            <button class="bg-gray-100 hover:bg-gray-200 rounded-full h-7 transition duration-150 ease-in px-4 py-2">
                                <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="idea-container cursor-pointer bg-white rounded-xl flex hover:shadow-card transition duration-150 ease-in">
            <div class="border-r border-gray-100 px-5 py-8">
                <div class="text-center">
                    <div class="font-semibold text-2xl">32</div>
                    <div class="text-gray-500">Votes</div>
                </div>

                <div class="mt-8">
                    <button class="w-20 bg-gray-200 font-bold text-xxs uppercase rounded-xl px-4 py-3 border border-gray-200 hover:border-gray-400 transition duration-150 ease-in">Vote</button>
                </div>
            </div>

            <div class="flex px-2 py-6">
                <a href="#" class="flex-none">
                    <img src="https://source.unsplash.com/200x200/?face&crop=face" class="w-14 h-14 rounded-xl" alt="avatar">
                </a>
                <div class="mx-4">
                    <h4 class="text-xl font-semibold">
                        <a href="#" class="hover:underline">A random title can go here!</a>
                    </h4>
                    <div class="text-gray-600 mt-3 line-clamp-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, veniam perspiciatis. Laborum amet, iste nemo incidunt itaque vitae voluptatum doloremque alias fuga quasi facere exercitationem, quis architecto provident minus aut fugit at laboriosam? Corrupti doloribus ullam repellat reprehenderit nisi? Dolor optio rem quidem magni perferendis ducimus quis nisi necessitatibus minima libero? Omnis ipsam id facilis aliquid pariatur. Earum ab officiis asperiores velit ipsa minima eum sequi assumenda aliquam deserunt ex, veniam odio optio porro quae, consequuntur possimus nostrum tenetur illum aliquid ea! Fuga vel voluptatibus excepturi doloribus asperiores? Obcaecati, possimus quidem? Nam reprehenderit enim animi culpa magni neque dignissimos assumenda!
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-xs font-semibold space-x-2 text-gray-400">
                            <div>10 hours ago</div>
                            <div>&bull;</div>
                            <div>Category One</div>
                            <div>&bull;</div>
                            <div class="text-gray-900">3 Comments</div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="relative bg-red text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 px-4 py-2">Closed</div>

                            <button class="bg-gray-100 hover:bg-gray-200 rounded-full h-7 transition duration-150 ease-in px-4 py-2">
                                <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="idea-container cursor-pointer bg-white rounded-xl flex hover:shadow-card transition duration-150 ease-in">
            <div class="border-r border-gray-100 px-5 py-8">
                <div class="text-center">
                    <div class="font-semibold text-2xl">35</div>
                    <div class="text-gray-500">Votes</div>
                </div>

                <div class="mt-8">
                    <button class="w-20 bg-gray-200 font-bold text-xxs uppercase rounded-xl px-4 py-3 border border-gray-200 hover:border-gray-400 transition duration-150 ease-in">Vote</button>
                </div>
            </div>

            <div class="flex px-2 py-6">
                <a href="#" class="flex-none">
                    <img src="https://source.unsplash.com/200x200/?face&crop=face" class="w-14 h-14 rounded-xl" alt="avatar">
                </a>
                <div class="mx-4">
                    <h4 class="text-xl font-semibold">
                        <a href="#" class="hover:underline">A random title can go here!</a>
                    </h4>
                    <div class="text-gray-600 mt-3 line-clamp-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, veniam perspiciatis. Laborum amet, iste nemo incidunt itaque vitae voluptatum doloremque alias fuga quasi facere exercitationem, quis architecto provident minus aut fugit at laboriosam? Corrupti doloribus ullam repellat reprehenderit nisi? Dolor optio rem quidem magni perferendis ducimus quis nisi necessitatibus minima libero? Omnis ipsam id facilis aliquid pariatur. Earum ab officiis asperiores velit ipsa minima eum sequi assumenda aliquam deserunt ex, veniam odio optio porro quae, consequuntur possimus nostrum tenetur illum aliquid ea! Fuga vel voluptatibus excepturi doloribus asperiores? Obcaecati, possimus quidem? Nam reprehenderit enim animi culpa magni neque dignissimos assumenda!
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-xs font-semibold space-x-2 text-gray-400">
                            <div>10 hours ago</div>
                            <div>&bull;</div>
                            <div>Category One</div>
                            <div>&bull;</div>
                            <div class="text-gray-900">3 Comments</div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="relative bg-green text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 px-4 py-2">Implemented</div>

                            <button class="bg-gray-100 hover:bg-gray-200 rounded-full h-7 transition duration-150 ease-in px-4 py-2">
                                <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="idea-container cursor-pointer bg-white rounded-xl flex hover:shadow-card transition duration-150 ease-in">
            <div class="border-r border-gray-100 px-5 py-8">
                <div class="text-center">
                    <div class="font-semibold text-2xl">22</div>
                    <div class="text-gray-500">Votes</div>
                </div>

                <div class="mt-8">
                    <button class="w-20 bg-gray-200 font-bold text-xxs uppercase rounded-xl px-4 py-3 border border-gray-200 hover:border-gray-400 transition duration-150 ease-in">Vote</button>
                </div>
            </div>

            <div class="flex px-2 py-6">
                <a href="#" class="flex-none">
                    <img src="https://source.unsplash.com/200x200/?face&crop=face" class="w-14 h-14 rounded-xl" alt="avatar">
                </a>
                <div class="mx-4">
                    <h4 class="text-xl font-semibold">
                        <a href="#" class="hover:underline">A random title can go here!</a>
                    </h4>
                    <div class="text-gray-600 mt-3 line-clamp-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, veniam perspiciatis. Laborum amet, iste nemo incidunt itaque vitae voluptatum doloremque alias fuga quasi facere exercitationem, quis architecto provident minus aut fugit at laboriosam? Corrupti doloribus ullam repellat reprehenderit nisi? Dolor optio rem quidem magni perferendis ducimus quis nisi necessitatibus minima libero? Omnis ipsam id facilis aliquid pariatur. Earum ab officiis asperiores velit ipsa minima eum sequi assumenda aliquam deserunt ex, veniam odio optio porro quae, consequuntur possimus nostrum tenetur illum aliquid ea! Fuga vel voluptatibus excepturi doloribus asperiores? Obcaecati, possimus quidem? Nam reprehenderit enim animi culpa magni neque dignissimos assumenda!
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center text-xs font-semibold space-x-2 text-gray-400">
                            <div>10 hours ago</div>
                            <div>&bull;</div>
                            <div>Category One</div>
                            <div>&bull;</div>
                            <div class="text-gray-900">3 Comments</div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="relative bg-purple text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 px-4 py-2">Considering</div>

                            <button class="bg-gray-100 hover:bg-gray-200 rounded-full h-7 transition duration-150 ease-in px-4 py-2">
                                <svg fill="currentColor" width="24" height="6"><path d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- en of container --}}
</x-app-layout>
