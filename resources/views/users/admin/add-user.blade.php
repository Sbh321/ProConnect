<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Add a New User
            </h2>
        </header>

        <form method="POST" action="/admin/users/">
            @csrf
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">Name</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name" />

                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">Email</label>
                <input type="email" class="border border-gray-200 rounded p-2 w-full" name="email"
                    value="{{ old('email') }}" />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="inline-block text-lg mb-2">
                    Password
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="password"
                    value="{{ old('password') }}" />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="avatar" class="inline-block text-lg mb-2">
                    Avatar
                </label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="avatar" />

                @error('avatar')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="banner" class="inline-block text-lg mb-2">
                    Banner
                </label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="banner" />

                @error('banner')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="location" class="inline-block text-lg mb-2">Address</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="location"
                    placeholder="Example: Remote, Boston MA, etc" />

                @error('location')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="occupation" class="inline-block text-lg mb-2">Occupation</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="occupation"
                    placeholder="Example: Remote, Boston MA, etc" />

                @error('occupation')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="education" class="inline-block text-lg mb-2">Education</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="education"
                    placeholder="Example: Remote, Boston MA, etc" />

                @error('education')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="bio" class="inline-block text-lg mb-2">
                    About Me
                </label>
                <textarea class="border border-gray-200 rounded p-2 w-full" name="bio" rows="5"
                    placeholder="Introduce yourself">
                    
                </textarea>
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-black">
                    Add
                </button>
            </div>
        </form>
    </x-card>
</x-layout>
