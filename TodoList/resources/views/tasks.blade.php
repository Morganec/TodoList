@extends('layouts.app')

@section('content')




        <div class="mt-4">

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
                       ADD
                    </button>
            </div>
        </form>


</div>
@endsection
