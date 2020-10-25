<!DOCTYPE html>
 <script src="{{ asset('js/app.js') }}"></script>
<html lang="en">
    <head>
        <title>Laravel Quickstart - Basic</title>

        <!-- CSS And JavaScript -->
    </head>

    <body>
        <div class="container" id="app">
            <nav class="navbar navbar-default">
                <!-- Navbar Contents -->
            </nav>
                    @yield('content')
        </div>

    </body>
</html>
