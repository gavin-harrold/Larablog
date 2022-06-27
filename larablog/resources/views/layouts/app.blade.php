<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Larablog</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-green-100">
    <nav class="p-6 bg-white flex justify-between mb-6">
        <ul class="flex items-center">
            <li>
                <a href="/" class="p-3">Home</a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="p-3">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('posts') }}" class="p-3">Post</a>
            </li>
        </ul>
        <ul>
            <li>
                <form action="/search" method="POST" role="search">
                    @csrf
                    <div>
                        <input type="text" name="q" placeholder="Search for users"
                        class="placeholder:italic placeholder:text-slate-400 bg-green-100 w-full border border-slate-300
                         rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 
                         focus:ring-1 sm:text-sm"> 
                    </div>
                </form>
            </li>
        </ul>
        <ul class="flex items-center">
            @auth
                <li>
                    <a href="{{ route('notification') }}" class="p-3">{{ auth()->user()->name }}</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="inline p-3">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            @endauth

            @guest
                <li>
                    <a href="{{ route('login') }}" class="p-3">Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="p-3">Register</a>
                </li>
            @endguest
        </ul>
    </nav> 
    @yield('content')
</body>
</html>