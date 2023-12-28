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
        
        $project = Project::factory()->create();

        $user = User::factory()->create(['name' => 'msa']);
        
        Task::factory(5)->for($user)->create(['status' => 'closed']);
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
            }
        });

    }

}
