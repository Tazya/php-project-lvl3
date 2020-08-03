<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('shared.metatags')
    </head>

    <body>
        <header>
            @include('shared.topline')
        </header>
        <main class="flex-grow-1">
            @include('flash::message')

            @yield('content')
        </main>
        @include('shared.footer')
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
</html>
