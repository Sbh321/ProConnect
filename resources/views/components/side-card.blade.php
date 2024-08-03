<div class="scrollable bg-white p-4 rounded-lg shadow-xl">
    @auth
        <a href="/users/{{ auth()->user()->id }}">
            <div class="flex items-center mb-4">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/no-profile.jpg') }}"
                    alt="Profile Picture" class="rounded-full mr-2 w-10" />
                <span>{{ auth()->user()->name }}</span>
            </div>
        </a>
    @else
        Login to view profile
    @endauth
    <ul>
        <li class="flex items-center mb-2">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                <i class="fa-solid fa-user-group text-blue-500 text-lg"></i>
            </div>
            <span class="ml-2">Followers</span>
        </li>
        <li class="flex items-center mb-2">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                <i class="fa-solid fa-bookmark text-blue-500 text-lg"></i>
            </div>
            <span class="ml-2">Saved</span>
        </li>
        <li class="flex items-center mb-2">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                <i class="fa-solid fa-code text-blue-500 text-lg"></i>
            </div>
            <span class="ml-2"><a href="/jobs">Development</a></span>
        </li>
    </ul>
</div>
