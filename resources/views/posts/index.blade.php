<x-layout :showFooter="false">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row" style="max-height: calc(89vh)">
            <!-- Left Section -->
            <div class="hidden lg:flex flex-col w-full lg:w-1/4 px-4 justify-between">
                <x-side-card />
            </div>

            <!-- Middle Section (Post Feed) -->
            <div x-data="{ scrollToTop() { this.$refs.scrollableContainer.scrollTop = 0 } }" x-init="scrollToTop" x-ref="scrollableContainer"
                class="w-full lg:w-1/2 px-4 scrollable" id="post-container">
                <div class="bg-white p-4 rounded-lg shadow-xl mb-4 md:hidden">
                    <div class="flex items-center my-2">
                        <form method="GET" action="#" class="w-full flex items-center">
                            <input type="text" name="status" placeholder="Search.."
                                class="w-full bg-gray-100 rounded-full py-2 px-4 outline-none mr-2" />
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-500 text-white py-2 px-6 rounded-full hover:bg-blue-600">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @auth
                    <div class="bg-white p-4 rounded-lg shadow-xl mb-4">
                        <div class="flex items-center my-2">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/no-profile.jpg') }}"
                                alt="Profile Picture" class="rounded-full mr-2 w-12 h-12" />
                            <form method="POST" action="/posts" class="w-full flex items-center">
                                @csrf
                                <input type="text" name="status" placeholder="Add a quick status..."
                                    class="w-full bg-gray-100 rounded-full py-2 px-4 outline-none mr-2" />
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="bg-blue-500 text-white h-10 py-2 px-6 shadow-xl rounded-full hover:bg-blue-600">
                                        Post
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-white p-4 rounded-lg shadow-xl mb-4">
                        <div class="flex items-center my-2">
                            <img src="{{ asset('images/no-profile.jpg') }}" alt="Profile Picture"
                                class="rounded-full mr-2 w-10" />
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
                @endauth

                @if (count($posts) > 0)
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                @else
                    <p>No Posts</p>
                @endif

                <!-- Loading More Posts -->
                <div id="load-more"></div>

                <!-- Loader and End Message -->
                <div id="loader" class="hidden">
                    <x-loader-card />
                </div>
                <div id="end-message" class="hidden">
                    <p class="text-center text-gray-500 text-sm my-4">Oops, you have reached the end!</p>
                </div>
            </div>

            <!-- Right Section -->
            <div class="hidden lg:block w-full lg:w-1/4 px-4">
                @if (auth()->user())
                    <x-connection-card :followers="$followers" :followedUsers="$followedUsers" :suggestedUsers="$suggestedUsers" />
                @else
                    <x-connection-card :users="$users" />
                @endif
            </div>
        </div>
    </div>

    <script>
        let skip = {{ $posts->count() }};
        let loading = false;

        document.addEventListener('DOMContentLoaded', function() {
            const scrollableContainer = document.querySelector('#post-container');
            const loader = document.querySelector('#loader');
            const endMessage = document.querySelector('#end-message');

            scrollableContainer.addEventListener('scroll', function() {
                if (scrollableContainer.scrollTop + scrollableContainer.clientHeight >= scrollableContainer
                    .scrollHeight && !loading) {
                    loadMorePosts();
                }
            });

            function loadMorePosts() {
                loading = true; // Set loading state to true
                loader.classList.remove('hidden'); // Show loader

                fetch(`{{ route('posts.loadMore') }}?skip=${skip}`, {
                        method: 'GET',
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data.trim() === '') {
                            // No more posts to load
                            loader.classList.add('hidden');
                            endMessage.classList.remove('hidden'); // Show end message
                            return;
                        }
                        document.getElementById('load-more').insertAdjacentHTML('beforebegin', data);
                        skip += 10;
                        console.log(skip);
                        loading = false; // Reset loading state
                        loader.classList.add('hidden'); // Hide loader
                        endMessage.classList.add('hidden'); // Hide end message if more posts are loaded
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loading = false; // Reset loading state on error
                        loader.classList.add('hidden'); // Hide loader
                    });
            }
        });
    </script>
</x-layout>
