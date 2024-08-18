<x-layout>
    <x-card class="p-10">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Jobs Listings
            </h1>
            <div class="mb-4">
                <a href="/jobs/create"
                    class="rounded-lg bg-black text-white py-2 px-5 hover:bg-white hover:text-black border-2 hover:border-black border-blueGray transition-all">Post
                    Job</a>
            </div>
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
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <p>
                                    {{ $job->id }}
                                </p>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/users/{{ $job->user_id }}" class="hover:underline">
                                    {{ $job->user->name }}
                                </a>
                                <span>
                                    ({{ $job->user_id }})
                                </span>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/jobs/{{ $job->id }}" class="hover:underline">
                                    {{ $job->title }}
                                </a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <x-job-tags :tagsCsv="$job->tags" />
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                {{-- here add overlay that shows each and every info about the job listing in a model overlay --}}
                                <a href="#"><i class="fa-solid fa-circle-info text-2xl"></i></a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/jobs/{{ $job->id }}/edit" class="text-blue-400 rounded-xl"><i
                                        class="fa-solid fa-pen-to-square"></i>
                                    Edit</a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form method="POST" action="/jobs/{{ $job->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 focus:outline-none"><i
                                            class="fa-solid fa-trash mr-2"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="border-gray-300">
                        <td class="text-lg py-8 px-4 border-t border-b border-gray-300" colspan="5">
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
</x-layout>
