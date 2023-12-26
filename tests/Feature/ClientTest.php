<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response as HttpResponse;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function DatabaseHasInitialData(): void
    {
        $this->assertDatabaseCount('users' , 2);
    
        $this->assertDatabaseHas('users', [
            'email' => 'ahmedelithy99@gmail.com',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'sally@example.com',
        ]);


        $user = User::factory()->create();

        $user->delete();
        
        $this->assertModelMissing($user);


    }


    /**
     * @test
     */
    public function itRetrieveClients(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $response = $this->get('/clients');

        $response->assertOk();
        $response->assertViewIs('clients.index');

    }

    /**
     * @test
     */
    public function itCannStore(): void
    {
        
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $response = $this->post('/clients' , [
            
            'name' => 'asdsd' ,
            'address' => 'asdasdas' ,
            'phone_number' => '123456789',
            'email' => 'asdsa@gmail.com'

        ]);
        
        $response->assertValid();
        
        $this->assertDatabaseHas('clients', [
            'email' => 'asdsa@gmail.com',
        ]);
        
        
    }


    /**
     * @test
     */
    public function itCannotStoreIfInvalidInputs(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $response = $this->post('/clients' , [
            
            'name' => 'asdsd' ,
            'address' => 'asdasdas' ,
            'phone_number' => '',
            'email' => ''

        ]);
        
        $response->assertInvalid();
        
        
    }


    /**
     * @test
     */
    public function itCanUpdate(): void
    {   
        $this->withoutExceptionHandling();
    

        $user =User::where('is_admin' , true)->get();

        
        $this->actingAs($user[0]);

        $client = Client::factory()->create();
        
        $client2 = Client::factory()->create();
        
        
        $response = $this->put("/clients/$client->id" , [
            
            'name' => 'asdsd' ,
            'address' => 'asdasdas' ,
            'phone_number' => '123456789',
            'email' => 'asasas@gmail.com'
        ]);
        
        $response->assertValid();

        $this->assertDatabaseHas('clients' , ['email' => 'asasas@gmail.com']);
        
        $response->assertRedirectToRoute('clients.index');


        
        


    }

    /**
     * @test
     */
    public function itCannotUpdateUnAuthoizedUser(): void
    {   
        // $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user);

        $client = Client::factory()->create();
        
        
        
        $response = $this->put("/clients/$client->id" , [
            
            'name' => 'asdsd' ,
            'address' => 'asdasdas' ,
            'phone_number' => '123456789',
            'email' => 'msa@gmail.com'
        ]);
        
        $response->assertStatus(403);
    
    }


    /**
     * @test
     */
    public function itCannotUpdateInvalidInputs(): void
    {   
        // $this->withoutExceptionHandling();

        $user =User::where('is_admin' , true)->get();

        $this->actingAs($user[0]);

        $client = Client::factory()->create();
        $client2 = Client::factory()->create();
        
        
        $response = $this->put("/clients/$client->id" , [
            
            'name' => 'asdsd' ,
            'address' => 'asdasdas' ,
            'phone_number' => '123456789',
            'email' => $client2->email
        ]);
        
        $response->assertInvalid();
    
    }

    /**
     * @test
     */

    public function itCanDelete()
    {
        $this->withoutExceptionHandling();

        $user =User::where('is_admin' , true)->get();

        $this->actingAs($user[0]);

        $client = Client::factory()->create();

        $this->assertDatabaseHas('clients' , ['id' => $client->id]);

        $response = $this->delete('clients/'.$client->id);

        $this->assertModelMissing($client);

    }

    /**
     * @test
     */

    public function itCannotDelete()
    {
        // $this->withoutExceptionHandling();

        $user =User::factory()->create();

        $this->actingAs($user);

        $client = Client::factory()->create();


        $response = $this->delete('clients/'.$client->id);

        $response->assertStatus(403);

    }










}
