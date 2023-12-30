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
        
        
        Project::factory(3)->has(User::factory())->create(['status' => Project::STATUS[1]]);
        Project::factory(3)->has(User::factory())->create(['status' => Project::STATUS[0]]);
        Project::factory(3)->has(User::factory())->create(['status' => Project::STATUS[2]]);
        
        // Client::factory(5)->create();
        // Task::factory(3)->create();
        // Task::factory(3)->create(['status' => 'closed']);
        // Task::factory(3)->create(['status' => 'in progress']);
        // Task::factory(3)->create(['status' => 'pending']);
}
}
