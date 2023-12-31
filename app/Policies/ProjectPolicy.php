<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    
    public function updateUser(User $user , Project $project)
    {
        if($user->is_admin == true)
        {
            return true;
        }

    }

    public function delete(User $user , Project $project)
    {
        return $user->is_admin == true ;
    }
}
