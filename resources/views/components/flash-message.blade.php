@if (session()->has('message'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="transform opacity-0 translate-y-4"
        x-transition:enter-end="transform opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="transform opacity-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 translate-y-4"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-6 py-4 rounded-lg shadow-xl">
        <p class="text-center">
            {{ session('message') }}
        </p>
    </div>
@endif
