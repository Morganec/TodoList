<?php

use Illuminate\Http\Request;
use App\Models\Task;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();

    return view('tasks', [
        'tasks' => $tasks
    ]);
});

Route::put('/task/{id}', function($id, Request $request)
{

$task = Task::where("id", $id)->update([
            "name" => $request->name,
            "isDone" => $request->isDone,
            "dueDate" => $request->dueDate
        ]);

});

Route::post('/task', function (Request $request) {
    $task = new Task;
    $task->name = $request->name;
    $task->dueDate = $request->dueDate;
    $task->isDone = false;
    $task->save();

    return redirect('/');
});


Route::delete('/task/{id}', function ($id) {
 Task::findOrFail($id)->delete();
    return redirect('/');
});
