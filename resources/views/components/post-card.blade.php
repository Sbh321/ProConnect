@props(['post'])

@php
    $isStarred = $post->stars()->where('user_id', auth()->id())->exists();
    $isSaved = $post->saves()->where('user_id', auth()->id())->exists();

    $comments = [];
@endphp

<div class="bg-white p-4 rounded-lg shadow-xl mb-4 relative">
    <div class="flex items-center mb-4">
        <img src="{{ $post->user->image ? asset('storage/' . $post->user->image) : asset('images/no-profile.jpg') }}"
            alt="image" class="rounded-full mr-2 w-10">
        <div>
            <h2 class="text-lg font-semibold">{{ $post->user->name }}</h2>
            <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
        </div>
        <div class="flex-1 flex justify-end">
            @if (auth()->id() === $post->user_id)
                <a href="{{ route('posts.edit', $post) }}" class="hover:underline mr-2"><i
                        class="fa-solid fa-pen"></i></a>
                <form action="{{ route('posts.delete', $post) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="hover:underline focus:outline-none"><i
                            class="fa-solid fa-trash "></i></button>
                </form>
            @else
                <i class="fa-solid fa-ellipsis-h"></i>
            @endif
        </div>
    </div>

    <p class="{{ empty($post->hashtags) ? 'mb-4' : 'mb-2' }}">
        {{ $post->status }}
    </p>

    @if (!empty($post->hashtags))
        <x-post-tags :hashtagsCsv="$post->hashtags" />
    @endif

    @if (!empty($post->image))
        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
            class="w-full rounded-lg my-4 aspect-video object-cover" />
    @endif

    <div class="flex justify-between text-gray-500 text-sm">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                <g fill="none" stroke="currentColor" stroke-width="1.5">
                    <path
                        d="m9.99 16.5l-.975.474c-1.98.548-2.971.822-3.505.245c-.534-.576-.258-1.62.295-3.71l.142-.54c.157-.595.236-.891.197-1.186c-.04-.294-.193-.553-.499-1.07l-.278-.47C4.29 8.422 3.752 7.512 4.11 6.787c.36-.724 1.379-.783 3.418-.9l.527-.03c.58-.034.869-.05 1.122-.185c.252-.135.439-.372.813-.848l.34-.432c1.316-1.673 1.974-2.509 2.73-2.38s1.11 1.137 1.817 3.154l.183.522c.201.573.302.86.497 1.07c.196.212.464.324 1.001.547l.489.204c1.89.786 2.835 1.18 2.942 1.983c.092.686-.477 1.283-1.64 2.29" />
                    <path
                        d="M15.252 10.689c-.987-1.18-1.48-1.77-2.048-1.68c-.567.091-.832.803-1.362 2.227l-.138.368c-.15.405-.226.607-.373.756c-.146.149-.348.228-.75.386l-.367.143c-1.417.555-2.126.833-2.207 1.4c-.08.567.52 1.049 1.721 2.011l.31.25c.342.273.513.41.611.597c.1.187.115.404.146.837l.029.394c.11 1.523.166 2.285.683 2.545c.517.26 1.154-.155 2.427-.983l.329-.215c.362-.235.543-.353.75-.387c.208-.033.42.022.841.132l.385.1c1.485.386 2.228.58 2.629.173c.4-.407.193-1.144-.221-2.62l-.108-.38c-.117-.42-.176-.63-.147-.837c.03-.208.145-.39.374-.756l.21-.332c.807-1.285 1.21-1.927.94-2.438c-.269-.511-1.033-.553-2.562-.635l-.396-.022c-.434-.023-.652-.035-.841-.13c-.19-.095-.33-.263-.61-.599z" />
                </g>
            </svg>

            @php
                $starCount = $post->stars()->count();
                if ($starCount >= 1000000) {
                    $starCountFormatted = round($starCount / 1000000, 1) . 'M';
                } elseif ($starCount >= 1000) {
                    $starCountFormatted = round($starCount / 1000, 1) . 'K';
                } else {
                    $starCountFormatted = $starCount;
                }
            @endphp

            <span>
                {{ $starCountFormatted }} {{ $starCount == 1 ? 'Star' : 'Stars' }}
            </span>
        </div>
        <div>
            <span class="">{{ $post->comments->count() }}
                {{ $post->comments->count() == 1 ? 'Comment' : 'Comments' }}</span>
        </div>
    </div>
    <hr class="my-2" />
    <div class="flex justify-between text-gray-500 text-sm">
        <button class="flex items-center hover:text-blue-500 focus:outline-none w-24"
            onclick="toggleStar({{ $post->id }}, this)">
            <i class="{{ $isStarred ? 'fa-solid fa-star' : 'fa-regular fa-star' }} mr-2"></i>
            <span>{{ $isStarred ? 'Unstar' : 'Star' }}</span>
        </button>
        <button onclick="fetchComments({{ $post->id }})"
            class="flex items-center hover:text-blue-500 focus:outline-none w-24">
            <i class="fa-regular fa-comments mr-2"></i>
            <span>Comment</span>
        </button>
        <button class="flex items-center hover:text-blue-500 focus:outline-none"
            onclick="toggleSave({{ $post->id }}, this)">
            <i class="{{ $isSaved ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark' }} mr-2"></i>
            <span>Save</span>
        </button>
    </div>

    <!-- Comment Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-70 z-10 hidden">
        <div class="flex justify-center items-center h-full">
            <div id="commentsModal"
                class="relative bg-white p-8 rounded-lg w-11/12 md:w-2/3 lg:w-1/2 max-h-[100vh] overflow-y-auto">
                <button onclick="showComments()"
                    class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <h3 class="text-lg font-semibold mb-4">Comments</h3>

                <div class="scrollable max-h-[55vh]">
                    <div id="cont"></div>
                </div>

                <form action="/posts/{{ $post->id }}/comments" method="POST" class="mt-6">
                    @csrf
                    <div class="flex items-center">
                        <input type="text" name="body" class="w-full border-gray-300 rounded-lg shadow-sm"
                            placeholder="Add a comment" required>
                        <button type="submit"
                            class="bg-blue-500 text-white rounded-lg px-4 py-2 ml-2 hover:bg-blue-600 focus:outline-none">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleStar(postId, element) {
        fetch(`/posts/${postId}/toggle-star`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'starred') {
                    element.querySelector('i').classList.remove('fa-regular');
                    element.querySelector('i').classList.add('fa-solid');
                    element.querySelector('span').textContent = 'Unstar';
                } else {
                    element.querySelector('i').classList.remove('fa-solid');
                    element.querySelector('i').classList.add('fa-regular');
                    element.querySelector('span').textContent = 'Star';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function toggleSave(postId, element) {
        fetch(`/posts/${postId}/toggle-save`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'saved') {
                    element.querySelector('i').classList.remove('fa-regular');
                    element.querySelector('i').classList.add('fa-solid');
                    element.querySelector('span').textContent = 'Unsave';
                } else {
                    element.querySelector('i').classList.remove('fa-solid');
                    element.querySelector('i').classList.add('fa-regular');
                    element.querySelector('span').textContent = 'Save';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    var cont = document.getElementById('cont');

    function fetchComments(postId) {
        fetch(`/posts/${postId}/comments`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const comments = data.comments;
                showComments(comments);
            })
            .catch(error => console.error('Error:', error));
    }

    function showComments(comments) {
        document.querySelector('.fixed').classList.toggle('hidden');

        if (comments && comments.length > 0) {
            // Clear the existing content
            cont.innerHTML = '';

            // Create a new list element
            const ul = document.createElement('ul');
            ul.className = 'space-y-4';

            // Iterate over the comments and create list items
            comments.map(comment => {
                const li = document.createElement('li');
                li.className =
                    'flex items-center bg-gray-200 rounded-xl px-4 py-2 transition-all cursor-pointer hover:bg-gray-300';

                const img = document.createElement('img');
                img.src = comment.user_image ? `storage/${comment.user_image}` : 'images/no-profile.jpg';
                img.alt = 'Profile Picture';
                img.className = 'rounded-full w-8 h-8 mr-2';

                const div = document.createElement('div');

                const userName = document.createElement('p');
                userName.className = 'font-semibold';
                userName.innerText = comment.user;

                const createdAt = document.createElement('p');
                createdAt.className = 'text-gray-500 text-sm';
                createdAt.innerText = comment.created_at;

                const body = document.createElement('p');
                body.innerText = comment.body;

                div.appendChild(userName);
                div.appendChild(createdAt);
                div.appendChild(body);
                li.appendChild(img);
                li.appendChild(div);

                ul.appendChild(li);
            });

            cont.appendChild(ul);
        } else {
            // Clear the existing content
            cont.innerHTML = '';

            const p = document.createElement('p');
            p.innerText = 'No comments yet. Be the first to comment!';
            cont.appendChild(p);
        }
    }
</script>
