<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Notifications\TaskForUser;
use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification ;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['user' , 'project'])->filterStatus(request('status'))->paginate(10);

        return view('tasks.index' , compact('tasks'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        

        return view('tasks.create' , compact('users','projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $att = $request->validated();

        $task = Task::create($att);

        Notification::send($task->user , new TaskForUser($task));

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show' , compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::all();
        $projects = Project::all();
        
        return view('tasks.edit', compact('projects', 'users', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('updateUser' , $task);
        
        $att = $request->validated();


        $task->update($att);


        return redirect()->route("tasks.show" , $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete' , $task);
        
        // $task->project->users()->detach();
        
        $task->delete();

        return redirect()->route('tasks.index');
    }
}
