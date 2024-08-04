@props(['hashtagsCsv'])

@php
    $hashtags = explode(',', $hashtagsCsv);
@endphp

<div class="flex mb-2">
    @foreach ($hashtags as $hashtag)
        <p class="text-blue-500 hover:text-blue-600 mr-2">
            <a href="/search/?hashtag={{ $hashtag }}">#{{ $hashtag }}</a>
        </p>
    @endforeach
</div>
