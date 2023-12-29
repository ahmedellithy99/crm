<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
    public function index()
    {   
        if(!auth()->user()->tokenCan('fetching'))
        {
            abort(403);
        }
        
        $projects =Project::with(['users' , 'client' , 'tasks'])->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request)
    {

        if(!auth()->user()->tokenCan('store'))
        {
            abort(403);
        }
        $validated =$request->validated();
        
        $project =DB::transaction(function() use ($validated){
            $project = Project::create(Arr::except($validated , ['user_id']));
            
            $project->users()->attach($validated['user_id']);

            return $project;
        });

        return ProjectResource::make($project->load(['users' , 'client']));        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {

        $project->loadCount(['users' => fn($query) => $query->where('is_admin' , true) ])->load(['users']);
        
        return ProjectResource::make($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
