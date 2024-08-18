<x-layout>
    <x-card class="p-10">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Users
            </h1>
            <div class="mb-4">
                <a href="/admin/users/add"
                    class="rounded-lg bg-black text-white py-2 px-5 hover:bg-white hover:text-black border-2 hover:border-black border-blueGray transition-all">Add
                    User</a>
            </div>
        </header>

        <table class="w-full table-auto rounded-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">ID</th>
                    <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">Name</th>
                    <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">isAdmin</th>
                    <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">More</th>
                    <th class="px-4 py-2 border-t border-b border-gray-300 text-left text-lg">Delete</th>
                </tr>
            </thead>
            <tbody>
                @unless ($users->isEmpty())
                    @foreach ($users as $user)
                        <tr class="border-gray-300">
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <p>
                                    {{ $user->id }}
                                </p>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/users/{{ $user->id }}" class="hover:underline">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <p class="">
                                    {{ $user->isAdmin ? 'Yes' : 'No' }}
                                </p>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                {{-- here add overlay that shows each and every info about the user in a model overlay --}}
                                <a href="#"><i class="fa-solid fa-circle-info text-2xl"></i></a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form method="POST" action="/admin/users/{{ $user->id }}">
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
                            <p class="text-center">No Users found.</p>
                        </td>
                    </tr>
                @endunless
            </tbody>
        </table>

        <div class="mt-6 p-4">
            {{ $users->links() }}
        </div>
    </x-card>
</x-layout>
