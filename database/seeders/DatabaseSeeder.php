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
        $user = User::factory()->create();
        $alo = User::factory()->create();
        $project = Project::factory()->create();
        Client::factory()->create();
        Task::factory()->create();

        $user->projects()->attach($project);

        $project->users()->attach($alo);
        
    }
}
