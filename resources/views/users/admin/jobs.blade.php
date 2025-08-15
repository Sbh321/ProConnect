<x-layout>
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0 p-6">
            <h2 class="text-2xl font-bold mb-6 uppercase">Admin Panel</h2>
            <nav class="flex flex-col gap-3">
                <a href="{{ route('dashboard') }}"
                    class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                    Posts
                </a>

                <a href="{{ route('usersDashboard') }}"
                    class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('usersDashboard') ? 'bg-gray-700' : '' }}">
                    Users
                </a>

                <a href="{{ route('jobsDashboard') }}"
                    class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('jobsDashboard') ? 'bg-gray-700' : '' }}">
                    Jobs
                </a>
            </nav>
        </aside>

        {{-- Main content --}}
        <main class="flex-1 p-6">
            <x-card class="p-10 mx-4 my-2">
                <header class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold uppercase">
                        Manage Gigs Listing
                    </h1>

                    <a href="/jobs/create"
                        class="rounded-lg bg-black text-white py-2 px-5 hover:bg-white hover:text-black border-2 hover:border-black border-blueGray transition-all">
                        Post Gig
                    </a>
                </header>

                <table class="w-full table-auto rounded-sm">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">ID</th>
                            <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">User (ID)</th>
                            <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">Title</th>
                            <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">Tags</th>
                            <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">More</th>
                            <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">Edit</th>
                            <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @unless ($jobs->isEmpty())
                            @foreach ($jobs as $job)
                                <tr class="border-gray-300">
                                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">{{ $job->id }}</td>
                                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                        <a href="/users/{{ $job->user_id }}"
                                            class="hover:underline">{{ $job->user->name }}</a>
                                        <span>({{ $job->user_id }})</span>
                                    </td>
                                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                        <a href="/jobs/{{ $job->id }}"
                                            class="hover:underline">{{ $job->title }}</a>
                                    </td>
                                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                        <x-job-tags :tagsCsv="$job->tags" />
                                    </td>
                                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                        {{-- overlay modal for job details --}}
                                        <a href="#"><i class="fa-solid fa-circle-info text-2xl"></i></a>
                                    </td>
                                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                        <a href="/jobs/{{ $job->id }}/edit" class="text-blue-400 rounded-xl">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                    </td>
                                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                        <form method="POST" action="/jobs/{{ $job->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 focus:outline-none">
                                                <i class="fa-solid fa-trash mr-2"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="border-gray-300">
                                <td class="text-lg py-8 px-4 border-t border-b border-gray-300" colspan="7">
                                    <p class="text-center">No jobs found.</p>
                                </td>
                            </tr>
                        @endunless
                    </tbody>
                </table>

                <div class="mt-6 p-4">
                    {{ $jobs->links() }}
                </div>
            </x-card>
        </main>
    </div>
</x-layout>
