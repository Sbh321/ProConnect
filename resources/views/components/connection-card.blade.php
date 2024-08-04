@if (auth()->user())
    <div x-data="{
        scrollToTop() {
            this.$refs.scrollableContainer.scrollTop = 0;
        }
    }" x-init="scrollToTop" class="scrollable bg-white p-4 rounded-lg shadow-xl"
        x-ref="scrollableContainer">

        <!-- Followers Section -->
        @if ($followers->isNotEmpty())
            <div class="mb-4">
                <h2 class="text-xl font-bold mb-4">Followers</h2>
                <ul>
                    @foreach ($followers as $user)
                        <a href="/users/{{ $user->id }}">
                            <li class="flex items-center mb-2 hover:bg-gray-200 cursor-pointer rounded-lg p-2">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile.jpg') }}"
                                    alt="{{ $user->name }}" class="rounded-full mr-2 w-10 h-10 object-cover" />
                                <span>{{ $user->name }}</span>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Following Section -->
        @if ($followedUsers->isNotEmpty())
            <div class="mb-4">
                <h2 class="text-xl font-bold mb-4">Following</h2>
                <ul>
                    @foreach ($followedUsers as $user)
                        <a href="/users/{{ $user->id }}">
                            <li class="flex items-center mb-2 hover:bg-gray-200 cursor-pointer rounded-lg p-2">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile.jpg') }}"
                                    alt="{{ $user->name }}" class="rounded-full mr-2 w-10 h-10 object-cover" />
                                <span>{{ $user->name }}</span>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Suggested Section -->
        @if ($suggestedUsers->isNotEmpty())
            <div>
                <h2 class="text-xl font-bold mb-4">Suggested</h2>
                <ul>
                    @foreach ($suggestedUsers as $user)
                        <a href="/users/{{ $user->id }}">
                            <li class="flex items-center mb-2 hover:bg-gray-200 cursor-pointer rounded-lg p-2">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile.jpg') }}"
                                    alt="{{ $user->name }}" class="rounded-full mr-2 w-10 h-10 object-cover" />
                                <span>{{ $user->name }}</span>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@else
    <div x-data="{
        scrollToTop() {
            this.$refs.scrollableContainer.scrollTop = 0;
        }
    }" x-init="scrollToTop" class="scrollable bg-white p-4 rounded-lg shadow-xl"
        x-ref="scrollableContainer">
        <div>
            <h2 class="text-xl font-bold mb-4">Explore Users</h2>
            <ul>
                @foreach ($users as $user)
                    <a href="/users/{{ $user->id }}">
                        <li class="flex items-center mb-2 hover:bg-gray-200 cursor-pointer rounded-lg p-2">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile.jpg') }}"
                                alt="{{ $user->name }}" class="rounded-full mr-2 w-10 h-10 object-cover" />
                            <span>{{ $user->name }}</span>
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
@endif
