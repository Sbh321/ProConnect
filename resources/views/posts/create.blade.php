<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24 shadow-xl rounded-lg">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create a Post
            </h2>
            <p class="mb-4">Add a post</p>
        </header>

        <form method="POST" action="/posts" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="status" class="inline-block text-lg mb-2">Status</label>
                <textarea name="status" id="status" cols="10" rows="5" class="border border-gray-200 rounded p-2 w-full">{{ old('status', request('status')) }}</textarea>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="hashtags" class="inline-block text-lg mb-2">
                    Tags (Comma Separated)
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="hashtags"
                    placeholder="Example: Post,proConnect,Laravel, etc" value="{{ old('hashtags') }}" />

                @error('hashtags')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="inline-block text-lg mb-2">Upload Image</label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="image" />
                @error('image')
                    <p class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-black">
                    Submit
                </button>
            </div>
        </form>
    </x-card>
</x-layout>
