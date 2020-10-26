@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
je suis ici

@foreach ($tasks as $task)
                            <div>
                                <!-- Task Name -->
                                <span class="task-name">
                                <task :task="{{$task}}"></task>
                                    <div>{{ $task->name }}</div>
                                </span>
                            </div>
                        @endforeach



  <form action="/task" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Task Name -->
            <div class="form-group">
                <label for="task">add Task</label>
                   <div> <input type="text" name="name" id="name" class="form-control"></div>
            </div>

            <!-- Add Task Button -->
            <div class="form-group">
                    <button type="submit" class="btn btn-default">
                        Add Task
                    </button>
            </div>
        </form>
    </div>

@endsection
