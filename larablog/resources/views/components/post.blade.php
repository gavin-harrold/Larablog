@props(['post' => $post])

<div>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    <div class="mb-4">
        <a href="{{ route('users.posts', $post->user) }}" 
            class="font-bold">{{ $post->user->name }}</a> <span class="text-gray-600
        text-sm">{{ $post->created_at->diffForHumans() }}</span>
        
        <p class="mb-2">{{ $post->body }}</p>

        {{-- check if post has an image entry in db --}}
        @if ($post->img)
            {{-- check if file exists (strictly for seeding purposes) --}}
            @if(file_exists('storage/'.$post->img))
                <span>
                    <img class="hidden w-70 ml-3 md:block" src="{{ asset('storage/'.$post->img) }}" alt="">
                </span>
            @else 
            {{-- use seeded url for image instead --}}
            {{-- test commit --}}
                <span>
                    <img class="hidden w-70 ml-3 md:block" src="{{$post->img}}" alt="">
                </span>
            @endif
        @endif

        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-blue-500">Delete</button>
            </form>
        @endcan

        <div class="flex items-center">
            @auth
            
                @if (!$post->likedBy(auth()->user()))
                    <form action="{{ route('posts.likes', $post) }}" method="POST" class="mr-1">
                        @csrf
                        <button type="submit" class="text-blue-500">Like</button>
                    </form>
                @else
                    <form action="{{ route('posts.likes', $post) }}" method="POST" class="mr-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-blue-500">Unlike</button>
                    </form>
                @endif
            @endauth
            
            <span>{{ $post->likes->count() }} {{ Str::plural('like',
            $post->likes->count()) }}</span>
        </div>
    </div>
</div>