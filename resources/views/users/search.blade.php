<x-layout :showFooter="false">
    <div class="px-4 md:flex md:flex-row ">
        <div class="md:w-1/4 md:mb-0 mb-4">
            <x-card>
                <ul class="flex gap-4 md:block">
                    @php
                        // Get the current keyword from the query string
                        $keyword = request()->query('keyword', '');

                        // Append keyword to URLs if it exists
                        $postSearchUrl = '/posts/search' . ($keyword ? '?keyword=' . urlencode($keyword) : '');
                        $userSearchUrl = '/users/search' . ($keyword ? '?keyword=' . urlencode($keyword) : '');
                    @endphp

                    <a href="{{ $postSearchUrl }}">
                        <li class="flex items-center mb-2 rounded-lg hover:bg-gray-200 cursor-pointer">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M4 20V4h16v16zm1.77-6.038h12.46v-1.116H5.77zm0 2.692h12.46v-.885H5.77z" />
                                </svg>
                            </div>
                            <span class="ml-2">Posts</span>
                        </li>
                    </a>
                    <a href="{{ $userSearchUrl }}">
                        <li class="flex items-center mb-2 rounded-lg hover:bg-gray-200 bg-gray-200 cursor-pointer">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center">
                                <i class="fa-solid fa-user-group text-lg"></i>
                            </div>
                            <span class="ml-2">Users</span>
                        </li>
                    </a>
                </ul>
            </x-card>
        </div>

        <div x-data="{ scrollToTop() { this.$refs.scrollableContainer.scrollTop = 0 } }" x-init="scrollToTop" x-ref="scrollableContainer"
            class="w-full md:w-3/4 px-4 scrollable" id="post-container">
            <x-card>
                @if (count($users) > 0)
                    @foreach ($users as $user)
                        <li class="flex items-center mb-2">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile.jpg') }}"
                                alt="{{ $user->name }}" class="rounded-full mr-2 w-10 h-10 object-cover" />
                            <span>{{ $user->name }}</span>
                        </li>
                    @endforeach
                @else
                    <p>No Users Found</p>
                @endif
            </x-card>
        </div>
    </div>
</x-layout>
