<x-layout>
    <x-card class="max-w-[1000px] mx-auto mb-4">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit Profile
            </h2>
            {{-- <p class="mb-4">Edit: {{ $job->title }}</p> --}}
        </header>
    </x-card>
    <form action="/users/{{ $user->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="md:flex md:max-w-[1000px] mx-auto md:gap-4">
            <x-card class="p-10 w-full">
                <div class="mb-6">
                    <label for="name" class="inline-block text-lg mb-2">Name</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name"
                        value="{{ old('name', $user->name) }}" />

                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="inline-block text-lg mb-2">Email</label>
                    <input type="email" class="border border-gray-200 rounded p-2 w-full" name="email"
                        value="{{ old('email', $user->email) }}" />
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
                    <input type="password" class="border border-gray-200 rounded p-2 w-full" name="password"
                        value="{{ old('password') }}" />
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="inline-block text-lg mb-2">
                        Confirm Password
                    </label>
                    <input type="password" class="border border-gray-200 rounded p-2 w-full"
                        name="password_confirmation" value="{{ old('password_confirmation') }}" />
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </x-card>

            <x-card class="p-10 w-full">
                <div class="mb-6">
                    <label for="avatar" class="inline-block text-lg mb-2">
                        Avatar
                    </label>
                    <input type="file" class="border border-gray-200 rounded p-2 w-full" name="avatar" />

                    <img class="w-48 mr-6 mb-6"
                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile.jpg') }}"
                        alt="Laravel">

                    @error('avatar')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="banner" class="inline-block text-lg mb-2">
                        Banner
                    </label>
                    <input type="file" class="border border-gray-200 rounded p-2 w-full" name="banner" />

                    <img class="w-48 mr-6 mb-6"
                        src="{{ $user->banner ? asset('storage/' . $user->banner) : asset('images/no-banner.jpg') }}"
                        alt="Laravel">

                    @error('banner')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="location" class="inline-block text-lg mb-2">Address</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="location"
                        placeholder="Example: Remote, Boston MA, etc" value="{{ $user->location }}" />

                    @error('location')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="occupation" class="inline-block text-lg mb-2">Occupation</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="occupation"
                        placeholder="Example: Remote, Boston MA, etc" value="{{ $user->occupation }}" />

                    @error('occupation')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="education" class="inline-block text-lg mb-2">Education</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="education"
                        placeholder="Example: Remote, Boston MA, etc" value="{{ $user->education }}" />

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
                    {{ $user->bio }}
                </textarea>
                </div>

                <div class="mb-6">
                    <button class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-black">
                        Update Profile
                    </button>

                    <a href="/" class="text-black ml-4"> Back </a>
                </div>
            </x-card>
        </div>
    </form>
</x-layout>
