<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    
    public function itWorksYooHoooTask(): void
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);
        
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function itFiltersStatusForTasks(): void
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        
        $this->actingAs($user);
        
        $project = Project::factory()->create(['title' => 'aloalo']);

        $user = User::factory()->create(['name' => 'msa']);
        
        Task::factory(5)->for($user)->for($project)->create(['status' => 'closed']);
        Task::factory(2)->create();
        
        Task::factory(3)->for($project)->create(['status' => 'cancelled']);



        
        $response = $this->get('/tasks?status=closed');
        
        $response->assertViewHas('tasks');

        $response->assertViewHas('tasks' , function($tasks) {
            return count($tasks) == 5;
        });

        $response->assertViewHas('tasks' , function($tasks) {
            foreach($tasks as $task){
                if($task->user->name === 'msa')
                {
                    return true ;
                }

                if($task->project->title === 'aloalo')
                {
                    return true ;
                }
            }
        });

        $response->assertViewHas('tasks' , function($tasks) {
            foreach($tasks as $task){
                
                if($task->project->title === 'aloalo')
                {
                    return true ;
                }
            }
        });

    }


    /**
     * @test
     */

    public function itStoreTasks():void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $project = Project::factory()->create();
        
        // dd(now()->addDays(2)->toString());
        $response = $this->post('/tasks' , [
            
            'title' => 'asdsd' ,
            'description' => 'aloaloalo' ,
            'deadline' => now()->addDays(2),
            'user_id' => $user->id ,
            'project_id' => $project->id,
            'status' => 'closed'

        ]);


        
        $response->assertValid();

        $this->assertDatabaseHas('tasks', [
            'status' => 'closed',
        ]);
        
    } 

    /**
     * @test
     */

    public function itCannotStoreTasks():void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $project = Project::factory()->create();
        
        // dd(now()->addDays(2)->toString());
        $response = $this->post('/tasks' , [
            
            'title' => '' ,
            'description' => 'aloaloalo' ,
            'deadline' => now()->addDays(2),
            'user_id' => 10864 ,
            'project_id' => $project->id,
            'status' => 'opens'

        ]);

        $response->assertInvalid(['title' ,'status' , 'user_id']);
    
    } 

    /**
    * @test
    */
    public function itCannotUpdateInvalidInputsProjects(): void
    {   
        // $this->withoutExceptionHandling();

        $user =User::where('is_admin' , true)->first();

        $this->actingAs($user);

        $task = Task::factory()->create();
        $project = Project::factory()->create();
        
        
        $response = $this->put("/tasks/$task->id" , [
            
            'description' => 'aloaloalo' ,
            'deadline' => now()->addDays(2),
            'user_id' => 13456 ,
            'project_id' => $project->id,
            'status' => 'opens'
        ]);
        
        $response->assertInvalid(['status' , 'user_id']);
    
    }

    /**
     * @test
     */
    public function itCanUpdateTask(): void
    {   
        $this->withoutExceptionHandling();
    

        $user =User::where('is_admin' , true)->first();

        
        $this->actingAs($user);

        $task = Task::factory()->create(['title' => 'a7a']);
        $user = User::factory()->create();
        $project = Project::factory()->create();
        
        
        $response = $this->put("/tasks/$task->id" , [
            'title' => 'msa',
            'description' => 'aloaloalo' ,
            'deadline' => now()->addDays(2),
            'user_id' =>  $user->id,
            'project_id' => $project->id,
            'status' => 'closed'
        ]);
        
        $response->assertValid();

        $this->assertDatabaseHas('tasks' , ['status' => 'closed' , 'project_id' => $project->id , 'title' => 'msa']);
        
    }

    /**
     * @test
     */

    public function itCanDeleteTask()
    {
        $this->withoutExceptionHandling();

        $user =User::where('is_admin' , true)->first();

        $this->actingAs($user);

        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks' , ['id' => $task->id]);

        $response = $this->delete('tasks/'.$task->id);

        $this->assertModelMissing($task);

    }





}
