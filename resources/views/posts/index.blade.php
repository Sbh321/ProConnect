<x-layout :showFooter="false">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row">
            <!-- Left Section -->
            <div class="hidden lg:block w-full lg:w-1/4 px-4">
                <x-side-card />
            </div>

            <!-- Middle Section (Post Feed) -->
            <div x-data="{ scrollToTop() { this.$refs.scrollableContainer.scrollTop = 0 } }" x-init="scrollToTop" x-ref="scrollableContainer"
                class="w-full lg:w-1/2 px-4 scrollable" id="post-container">

                @auth
                    <div class="bg-white p-4 rounded-lg shadow-xl mb-4">
                        <div class="flex items-center my-2">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/no-profile.jpg') }}"
                                alt="Profile Picture" class="rounded-full mr-2 w-10" />
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

                <x-loader-card />
            </div>

            <!-- Right Section -->
            <div class="hidden lg:block w-full lg:w-1/4 px-4">
                <x-connection-card />
            </div>
        </div>
    </div>

    <script>
        let skip = {{ $posts->count() }};

        document.addEventListener('DOMContentLoaded', function() {
            const scrollableContainer = document.querySelector('#post-container');

            scrollableContainer.addEventListener('scroll', function() {
                if (scrollableContainer.scrollTop + scrollableContainer.clientHeight >= scrollableContainer
                    .scrollHeight) {
                    loadMorePosts();
                }
            });
        });

        function loadMorePosts() {
            fetch(`{{ route('posts.loadMore') }}?skip=${skip}`, {
                    method: 'GET',
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('load-more').insertAdjacentHTML('beforebegin', data);
                    skip += 5;
                    console.log(skip);
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</x-layout>
