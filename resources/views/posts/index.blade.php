<x-layout :showFooter="false">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row">
            <!-- Left Section -->
            <div class="hidden lg:block w-full lg:w-1/4 px-4">
                <x-side-card />
            </div>

            <!-- Middle Section (Post Feed) -->
            <div class="w-full lg:w-1/2 px-4 scrollable">
                @if (count($posts) > 0)
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                @else
                    <p>No Posts</p>
                @endif
            </div>

            <!-- Right Section -->
            <div class="hidden lg:block w-full lg:w-1/4 px-4">
                <x-connection-card />
            </div>
        </div>
    </div>

</x-layout>
