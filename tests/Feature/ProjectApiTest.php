<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */

    public function itFetchesAllProjects():void
    {
        $user =User::factory()->create();
        
        
        Project::factory()->create(['title' => 'aloalo' , 'status' => 'completed']);

        Project::factory(4)->create();
        

        $token = $user->createToken('msamsa' , ['fetching'])->plainTextToken;
        
        $response = $this->getJson('api/projects' , 
            [
                'Authorization' => 'Bearer '.$token 
            ] );

        
        $response->assertOk()->assertJsonPath('data.0.title' , 'aloalo');
        $this->assertCount(5 , $response->json('data'));
        $this->assertDatabaseHas('projects' ,   ['status' => 'completed'] );

    }


    /**
     * @test
     */

    public function itStoresProjects():void
    {
        $user =User::factory()->create();
        $client = Client::factory()->create();

        $token = $user->createToken('msamsa' , ['store'])->plainTextToken;
        
        $response = $this->postJson('api/projects' , 
            [
                'title' => 'msa' ,
                'description' => 'aloaloaloalo',
                'deadline' => '2023-12-31',
                'user_id' => $user->id ,
                'client_id' => $client->id,
                'status' => 'open'
            ]
            ,

            [
                'Authorization' => 'Bearer '.$token 
            ] );

        $response->dump();
        $response->assertCreated()->assertJsonPath('data.title' , 'msa');
        $this->assertCount(1 , $response->json('data.users'));
        $this->assertDatabaseHas('projects' ,   ['status' => 'open'] );

    }

    /**
     * @test
     */

    public function itShowsProjectAdminUser():void
    {

        $user =User::factory()->create(['is_admin' => true]);
        

        $users = User::factory(3)->create(['is_admin' => true]);

        $client = Client::factory()->create();

        $project = Project::factory()->has(User::factory(2))->create();
        $project->users()->attach($users);
        
        $token = $user->createToken('msamsa')->plainTextToken;
        
        $response = $this->getJson('api/projects/'.$project->id , 
            [
                'Authorization' => 'Bearer '.$token 
            ] );

        // $response->dump();
        $response->assertOk();
        $response->assertJsonPath('data.users_count' , 3);;

    }


}
