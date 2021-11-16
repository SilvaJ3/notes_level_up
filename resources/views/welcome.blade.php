<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <link rel="stylesheet" href="{{asset("css/app.css")}}">

    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 min-h-screen">
            <!-- component -->

            <header class=" bg-gray-100">
                <nav class="flex items-center justify-between p-6 h-20 bg-white shadow-sm">
                <div class="py-5 px-3 rounded-md bg-gradient-to-r from-black to-gray-500 text-sm text-white font-semibold shadow-lg hover:cursor-pointer hover:shadow-lg">LEVEL NOTE</div>
                <ul>
                    <li class="space-x-5 text-xl">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="hidden sm:inline-block text-gray-700 hover:text-indigo-700">Dashboard</a>
                            
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:inline-block text-gray-700 hover:text-indigo-700">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hidden sm:inline-block text-gray-700 hover:text-indigo-700">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                    </li>
                    <div class="sm:hidden space-y-1 hover:cursor-pointer">
                    <span class="w-10 h-1 bg-gray-600 rounded-full block"></span>
                    <span class="w-10 h-1 bg-gray-600 rounded-full block"></span>
                    <span class="w-10 h-1 bg-gray-600 rounded-full block"></span>
                    </div>
                </ul>
                </nav>
            </header>

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>


        <script src="{{  asset("js/all.min.js") }}"></script>
    </body>
</html>
    
