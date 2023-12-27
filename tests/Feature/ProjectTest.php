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
        $user = User::factory()->create();
        
        $this->actingAs($user);
        
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
        
        $user = User::factory()->create();
        
        $this->actingAs($user);
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

    /**
     * @test
     */

    public function itStoreProjects():void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $client = Client::factory()->create();
        
        // dd(now()->addDays(2)->toString());
        $response = $this->post('/projects' , [
            
            'title' => 'asdsd' ,
            'description' => 'aloaloalo' ,
            'deadline' => now()->addDays(2),
            'user_id' => $user->id ,
            'client_id' => $client->id,
            'status' => 'open'

        ]);


        
        $response->assertValid();

        $this->assertDatabaseHas('projects', [
            'title' => 'asdsd',
        ]);
        
    } 

    /**
     * @test
     */

    public function itCannotStoreProjects():void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $client = Client::factory()->create();
        
        // dd(now()->addDays(2)->toString());
        $response = $this->post('/projects' , [
            
            'title' => '' ,
            'description' => 'aloaloalo' ,
            'deadline' => now()->addDays(2),
            'user_id' => 10864 ,
            'client_id' => $client->id,
            'status' => 'opens'

        ]);

        $response->assertInvalid(['title' ,'status' , 'user_id']);
    
    } 

    /**
     * @test
     */

    public function itIsVeiwingCreate():void
    {
        
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        
        $this->actingAs($user);
        // $user = User::factory()->create();
        
        Client::factory()->create(['name' => 'msa']);
        Project::factory(3)->create();


        $response = $this->get('/projects/create');
        
        $response->assertViewHas('users');
        $response->assertViewHas('clients');


        $response->assertViewHas('clients' , function($clients) {
            foreach($clients as $client){
                if($client->name === 'msa')
                {
                    return true ;
                }
            }
        });
        
        
    }

    /**
     * @test
     */
    public function itCannotUpdateInvalidInputsProjects(): void
    {   
        // $this->withoutExceptionHandling();

        $user =User::where('is_admin' , true)->get();

        $this->actingAs($user[0]);

        $client = Client::factory()->create();
        $project = Project::factory()->create();
        
        
        $response = $this->put("/projects/$project->id" , [
            
            'description' => 'aloaloalo' ,
            'deadline' => now()->addDays(2),
            'user_id' => 13456 ,
            'client_id' => $client->id,
            'status' => 'opens'
        ]);
        
        $response->assertInvalid(['status' , 'user_id']);
    
    }

    /**
     * @test
     */
    public function itCanUpdateProjects(): void
    {   
        $this->withoutExceptionHandling();
    

        $user =User::where('is_admin' , true)->get();

        
        $this->actingAs($user[0]);

        $client = Client::factory()->create();
        $user = User::factory()->create();
        $project = Project::factory()->create(['title' => 'a7a']);
        
        
        $response = $this->put("/projects/$project->id" , [
            
            'description' => 'aloaloalo' ,
            'deadline' => now()->addDays(2),
            'user_id' =>  $user->id,
            'client_id' => $client->id,
            'status' => 'completed'
        ]);
        
        $response->assertValid();

        $this->assertDatabaseHas('projects' , ['status' => 'completed' , 'client_id' => $client->id , 'title' => 'a7a']);
        
    }







}
