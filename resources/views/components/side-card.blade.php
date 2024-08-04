<div class="scrollable bg-white p-4 rounded-lg shadow-xl">
    @auth
        <a href="/users/{{ auth()->user()->id }}">
            <div class="flex items-center hover:bg-gray-200 cursor-pointer rounded-lg p-2">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/no-profile.jpg') }}"
                    alt="Profile Picture" class="rounded-full mr-2 w-10 h-10" />
                <span>{{ auth()->user()->name }}</span>
            </div>
        </a>
    @else
        <h2 class="text-xl font-bold mb-4"><span class="text-blue-400 hover:text-blue-500"><a href="/login">Login</a></span>
            to create a profile
        </h2>
    @endauth
    <ul>
        @auth
            <a href="/users/{{ auth()->user()->id }}/followers">
                <li class="flex items-center hover:bg-gray-200 cursor-pointer rounded-lg p-2">
                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                        <i class="fa-solid fa-user-group text-blue-500 text-lg"></i>
                    </div>
                    <span class="ml-2">Followers</span>
                </li>
            </a>
            <a href="#">
                <li class="flex items-center hover:bg-gray-200 cursor-pointer rounded-lg p-2">
                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                        <i class="fa-solid fa-bookmark text-blue-500 text-lg"></i>
                    </div>
                    <span class="ml-2">Saved</span>
                </li>
            </a>
        @endauth
        <a href="/jobs">
            <li class="flex items-center hover:bg-gray-200 cursor-pointer rounded-lg p-2">
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                    <i class="fa-solid fa-code text-blue-500 text-lg"></i>
                </div>
                <span class="ml-2">Projects</span>
            </li>
        </a>
        <x-add-post />
    </ul>
</div>
