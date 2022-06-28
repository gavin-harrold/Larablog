@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-100 bg-white p-6 rounded-lg flex justify-center">
            @if (session('status'))
            <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
            {{ session('status') }}
            </div>
            @endif

            <div class="flex-col flex justify-center">
                <form action="{{ route('notification') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="destination" class="sr-only">Destination</label>
                        <input type="url" name="destination" id="destination" placeholder="Target URL"
                        class="bg-gray-100 border-2 w-full p-4 rounded-lg">

                        @error('destination')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                    <div class="mb-4">
                        <label for="noti-options">Choose notification triggers:</label>
                        <select name="noti-options" id="noti-options" 
                        class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                            <option value="no-option" selected>None</option>
                            <option value="post-create">Post Creation</option>
                            <option value="post-like">Post Liked</option>
                            <option value="all-option">All</option>
                        </select>

                        @error('noti-options')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    

                    <div>
                        <button type="submit" class="bg-green-500 text-white px-4 py-3 
                        rounded font-medium w-full">Submit</button>
                    </div>
                </form>
            </div>

    
        </div>
    </div>

@endsection