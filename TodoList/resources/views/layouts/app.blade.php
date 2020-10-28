<!DOCTYPE html>
 <script src="{{ asset('js/app.js') }}"></script>
<html lang="en">
    <head>
        <title>Laravel Quickstart - Basic</title>

        <!-- CSS And JavaScript -->
    </head>

    <body>
        <div class="mt-2" id="app">
            <task-list :task-list="{{$tasks}}"></task-list>
        </div>
    </body>
</html>
