@extends('layouts.app')

@section('content')
    <div class="flex justify-center w-8/12 p-6">
        <div class="bg-white p-6 rounded-lg">
            @if (isset($results))
                <div>
                    <p>The search results for your query <b> {{ $query }} </b> are:</p>
                    <table class='table-auto'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $user)
                                <tr>
                                    <td class="p-2"><a class="text-blue-600" href="{{ route('users.posts', $user) }}">{{ $user->name }}</a></td>
                                    <td class="p-2">{{ $user->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No results found!</p>
            @endif
        </div>
    </div>
@endsection