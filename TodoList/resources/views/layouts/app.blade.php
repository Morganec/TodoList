<!DOCTYPE html>
 <script src="{{ asset('js/app.js') }}"></script>
<html lang="en">
    <head>
        <title>Laravel Quickstart - Basic</title>

        <!-- CSS And JavaScript -->
    </head>

    <body>
        <div class="container" id="app">
                    <task-list :task-list="{{$tasks}}"></task-list>
 @yield('content')
        </div>
    </body>
</html>
