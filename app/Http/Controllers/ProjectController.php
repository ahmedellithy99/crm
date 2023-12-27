<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Models\Project;
use App\Models\User;
use App\Models\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['users' , 'client' , 'tasks'])
        ->when(request('status') , fn($query) => $query->when(request('status') === 'all' , 
        fn($query) => $query->whereIn('status' , Project::STATUS), 
        fn($query) => $query->where('status' , request('status')))
        )
        ->get();

    

        return view('projects.index' , compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $users = User::all();
        $clients = Client::all();

        return view('projects.create' , compact('users','clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request)
    {
        $att = $request->validated();

        $project = Project::create(Arr::except($att ,'user_id'));
        $project->users()->attach($att['user_id']);

        return redirect()->route('projects.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show' , compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        $users = User::all();
        $clients = Client::all();
        
        return view('projects.edit', compact('project', 'users' , 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectStoreRequest $request, Project $project)
    {
        $this->authorize('updateUser' , $project);
        
        $att = $request->validated();


        $project->update(Arr::except($att ,'user_id'));

        if(isset($att['user_id'])){

            $project->users()->sync($att['user_id']);
        }

        return redirect()->route("projects.show" , $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
