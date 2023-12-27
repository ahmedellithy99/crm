<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
     */
    public function itWorks(): void
    {
        
        
        Project::factory()->create();
        
        $response = $this->get('/projects');

        $response->assertStatus(200);
    }


    /**
     * @test
     */
    public function itFiltersStatus(): void
    {
        $this->withoutExceptionHandling();
        
        // $user = User::factory()->create();
        $client = Client::factory()->create(['name' => 'msa']);
        Project::factory(3)->create(['status' => 'completed']);
        Project::factory(2)->create();
        Project::factory(5)->for($client)->create(['status' => 'cancelled']);



        
        $response = $this->get('/projects?status=cancelled');
        
        $response->assertViewHas('projects');

        $response->assertViewHas('projects' , function($projects) {
            return count($projects) == 5;
        });

        $response->assertViewHas('projects' , function($projects) {
            foreach($projects as $project){
                if($project->client->name === 'msa')
                {
                    return true ;
                }
            }
        });

    }




}
