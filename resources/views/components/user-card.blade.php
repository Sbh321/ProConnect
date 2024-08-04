<a href="/users/{{ $user->id }}">
    <li class="flex items-center hover:bg-gray-200 cursor-pointer rounded-lg p-2">
        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/no-profile.jpg') }}"
            alt="{{ $user->name }}" class="rounded-full mr-2 w-10 h-10 object-cover" />
        <span>{{ $user->name }}</span>
    </li>
</a>
