@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="p-6">
                <h1 class="text-2xl font-medium mb-1">My Posts</h1>
                <p>Posted {{ auth()->user()->posts->count() }} {{ Str::plural('post', auth()->user()->posts->count()) }}
                and received {{ auth()->user()->receivedLikes->count() }} likes</p>
            </div>

            <div class="bg-white p-6 rounded-lg">
                @if (auth()->user()->posts->count())
                    @foreach (auth()->user()->posts as $post)
                        <x-post :post="$post" />
                    @endforeach

                    {{-- {{ auth()->user()->posts }} --}}
                @else
                    <p>{{ auth()->user()->name }} does not have any posts!</p>
                @endif
            </div>
        </div>
    </div>
@endsection