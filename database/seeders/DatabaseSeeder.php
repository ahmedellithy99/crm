<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        Client::factory(5)->create();

        Project::factory(3)->has(User::factory())->create(['status' => Project::STATUS[1]]);
        Project::factory(3)->has(User::factory())->create(['status' => Project::STATUS[0]]);
        Project::factory(3)->has(User::factory())->create(['status' => Project::STATUS[2]]);

        Task::factory(10)->create();

        

        




        
        
    }
}
