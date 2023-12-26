<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{

    public function delete(User $user , Client $client)
    {
        return $user->is_admin == true ;
    }

    public function update(User $user , Client $client)
    {
        return $user->is_admin == true ;
    }
}
