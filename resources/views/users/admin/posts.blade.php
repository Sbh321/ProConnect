<x-layout>
    <x-card class="p-10">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Posts
            </h1>
            <div class="mb-4">
                <a href="/posts/create"
                    class="rounded-lg bg-black text-white py-2 px-5 hover:bg-white hover:text-black border-2 hover:border-black border-blueGray transition-all">Add
                    Post</a>
            </div>
        </header>

        <table class="w-full table-auto rounded-sm">
            <tbody>
                @unless ($posts->isEmpty())
                    @foreach ($posts as $post)
                        <tr class="border-gray-300">
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="show.html">
                                    {{ $post->status }}
                                </a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/posts/{{ $post->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl"><i
                                        class="fa-solid fa-pen-to-square"></i>
                                    Edit</a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form method="POST" action="/posts/{{ $post->id }}">
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
                        <td class="text-lg py-8 px-4 border-t border-b border-gray-300" colspan="3">
                            <p class="text-center">No jobs found.</p>
                        </td>
                    </tr>
                @endunless
            </tbody>
        </table>

        <div class="mt-6 p-4">
            {{ $posts->links() }}
        </div>
    </x-card>
</x-layout>
