<x-layout :showFooter="false">
    <div class="profile-page">
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
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{ $user->followers()->count() }}</span><span
                                            class="text-sm text-blueGray-400">Followers</span>
                                    </div>
                                    <div class="mr-4 p-3 text-center">
                                        <span
                                            class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">10</span><span
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
            <div class="container mx-auto lg:px-36 px-4">
                @if (count($posts) > 0)
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                    <p class="text-center text-gray-500 text-sm my-4">Oops, no more posts to show!</p>
                @else
                    <div class="bg-white p-4 rounded-lg shadow-xl mb-4 mx-auto max-w-[500px]">
                        <div class="flex items-center my-2">
                            <form method="GET" action="/posts/create" class="w-full flex items-center">
                                <input type="text" name="status" placeholder="Add a post status..."
                                    class="w-full bg-gray-100 rounded-full py-2 px-4 outline-none mr-2" />
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="bg-blue-500 text-white py-2 px-6 rounded-full hover:bg-blue-600">
                                        Create
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <p class="text-center text-gray-500 text-sm my-4">Oops, No posts to show!</p>
                @endif
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
