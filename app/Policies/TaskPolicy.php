<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    public function updateUser(User $user , Task $task)
    {
        if($user->is_admin == true)
        {
            return true;
        }

    }

    public function delete(User $user ,Task $task)
    {
        return $user->is_admin == true ;
    }
}
