<x-layout :showFooter="false">
    <div class="profile-page mb-6">
        <section class="relative block h-500-px">
            <div class="absolute top-0 w-full h-full bg-center bg-cover"
                style="
            background-image: url('{{ $user->banner ? asset('storage/' . $user->banner) : asset('images/no-banner.jpg') }}');
          ">
                <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
            </div>
        </section>
        <section class="relative pt-1 bg-blueGray-200">
            <div class="container mx-auto lg:px-36 px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                                <div class="relative">
                                    <img alt="..."
                                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile.jpg') }}"
                                        class="shadow-xl h-36 w-36 rounded-full align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px">
                                </div>
                            </div>
                            <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
                                <div class="py-6 px-3 mt-32 sm:mt-0">
                                    @if (auth()->user())
                                        @if (auth()->user()->id === $user->id)
                                            <!-- Display the Edit form if the profile belongs to the logged-in user -->
                                            <div class="flex justify-end gap-2">
                                                <form action="/users/{{ $user->id }}/edit">
                                                    <button class="focus:outline-none mr-2" title="Edit Profile">
                                                        <i
                                                            class="fa-solid fa-pen-to-square text-gray-500 hover:text-gray-700 text-2xl"></i>
                                                    </button>
                                                </form>
                                                <form action="/posts/create">
                                                    <button class="focus:outline-none" title="Add Post">
                                                        <i
                                                            class="fa-solid fa-plus text-gray-500 hover:text-gray-700 text-2xl"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <!-- Display the Follow/Unfollow button if the profile does not belong to the logged-in user -->
                                            <button id="followButton"
                                                class="bg-blue-500 active:bg-blue-600 uppercase text-white font-bold hover:shadow-xl text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150"
                                                type="button" onclick="toggleFollow()">
                                                {{ Auth::user()->isFollowing($user) ? 'Unfollow' : 'Follow' }}
                                            </button>
                                        @endif
                                    @else
                                        <button id="followButton"
                                            class="bg-blue-500 active:bg-blue-600 uppercase text-white font-bold hover:shadow-xl text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150"
                                            type="button">
                                            <a href="/login">Follow</a>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full lg:w-4/12 px-4 lg:order-1">
                                <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                    <div class="mr-4 p-3 text-center">
                                        <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">
                                            {{ $user->followers()->count() }}
                                        </span>
                                        <span class="text-sm text-blueGray-400">Followers</span>
                                    </div>
                                    <div class="mr-4 p-3 text-center">
                                        <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">
                                            {{ $user->following()->count() }}
                                        </span>
                                        <span class="text-sm text-blueGray-400">Following</span>
                                    </div>
                                    <div class="mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{ $user->posts()->withCount('stars')->get()->sum('stars_count') }}</span><span
                                            class="text-sm text-blueGray-400">Stars</span>
                                    </div>
                                    <div class="lg:mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">89</span><span
                                            class="text-sm text-blueGray-400">Comments</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="text-4xl font-semibold leading-normal mb-8 text-blueGray-700 mb-2">
                                {{ $user->name }}
                            </h3>
                            @if ($user->location)
                                <div class="text-sm leading-normal mt-0 mb-2 text-blueGray-400 font-bold uppercase">
                                    <i class="fas fa-map-marker-alt mr-2 text-lg text-blueGray-400"></i>
                                    {{ $user->location }}
                                </div>
                            @endif

                            @if ($user->occupation)
                                <div class="mb-2 text-blueGray-600">
                                    <i
                                        class="fas fa-briefcase mr-2 text-lg text-blueGray-400"></i>{{ $user->occupation }}
                                </div>
                            @endif

                            @if ($user->education)
                                <div class="mb-2 text-blueGray-600">
                                    <i
                                        class="fas fa-university mr-2 text-lg text-blueGray-400"></i>{{ $user->education }}
                                </div>
                            @endif

                        </div>
                        @if ($user->bio)
                            <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                                <div class="flex flex-wrap justify-center">
                                    <div class="w-full lg:w-9/12 px-4">
                                        <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
                                            {{ $user->bio }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-1 bg-blueGray-200">
            <div class="px-4 md:flex md:flex-row md:gap-4" style="max-height: calc(89vh)">
                <div class="md:w-1/4 md:mb-0 mb-4">
                    <x-card>
                        <ul class="flex gap-4 md:block">
                            <a href="/users/{{ $user->id }}">
                                <li class="flex items-center mb-2 rounded-lg hover:bg-gray-200 cursor-pointer">
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M4 20V4h16v16zm1.77-6.038h12.46v-1.116H5.77zm0 2.692h12.46v-.885H5.77z" />
                                        </svg>
                                    </div>
                                    <span class="ml-2">Posts</span>
                                </li>
                            </a>
                            <a href="/users/{{ $user->id }}/saved">
                                <li class="flex items-center mb-2 rounded-lg hover:bg-gray-200 cursor-pointer">
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                                        </svg><svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M3 21V3h18v18zm15-4H6v1.5h12zM6 15.5h12V14H6zM6 12h12V6H6zm0 5v1.5zm0-1.5V14zM6 12V6zm0 2v-2zm0 3v-1.5z" />
                                        </svg>
                                    </div>
                                    <span class="ml-2">Saved Posts</span>
                                </li>
                            </a>
                            <a href="/users/{{ $user->id }}/followers">
                                <li
                                    class="flex items-center mb-2 rounded-lg hover:bg-gray-200 bg-gray-200 cursor-pointer">
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                                        <i class="fa-solid fa-user-group text-lg"></i>
                                    </div>
                                    <span class="ml-2">Followers</span>
                                </li>
                            </a>
                            <a href="/users/{{ $user->id }}/following">
                                <li class="flex items-center rounded-lg hover:bg-gray-200 cursor-pointer">
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                                        <i class="fa-solid fa-users text-lg"></i>
                                    </div>
                                    <span class="ml-2">Following</span>
                                </li>
                            </a>
                        </ul>
                    </x-card>
                </div>

                <div x-data="{ scrollToTop() { this.$refs.scrollableContainer.scrollTop = 0 } }" x-init="scrollToTop" x-ref="scrollableContainer"
                    class="w-full md:w-3/4 scrollable" id="post-container">
                    <x-card>
                        <div class="container mx-auto">
                            @if ($followers->isNotEmpty())
                                @foreach ($followers as $user)
                                    <x-user-card :user="$user" />
                                @endforeach
                            @else
                                <p>No Followers</p>
                            @endif
                        </div>
                    </x-card>
                </div>
            </div>
        </section>
    </div>

    <script>
        function toggleFollow() {
            fetch('/users/{{ $user->id }}/toggle-follow', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Update the button text based on follow/unfollow status
                    const followButton = document.getElementById('followButton');
                    followButton.textContent = data.message.includes('Followed') ? 'Unfollow' : 'Follow';

                    // Optionally update the followers count
                    const followersCountElement = document.querySelector('span[title="FollowersCount"]');
                    if (followersCountElement) {
                        followersCountElement.textContent = data.followers_count;
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</x-layout>
