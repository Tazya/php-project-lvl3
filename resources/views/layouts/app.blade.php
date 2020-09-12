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

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
                @endforeach
            @endif

            @yield('content')
        </main>
        @include('shared.footer')
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
</html>
