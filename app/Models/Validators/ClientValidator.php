<?php

namespace App\Models\Validators;

use App\Models\CLient;
use Illuminate\Validation\Rule;

class ClientValidator
{
    public function validate(CLient $client, array $attributes): array
    {
        return validator($attributes,
            [
                'name' => [Rule::when($client->exists , 'sometimes') ,'required' , 'string' , 'max:100'],
                'email' => [Rule::when($client->exists , 'sometimes') , 'unique:clients' ,'required' , 'string' , 'email'  , 'max:100'],
                'phone_number' => [Rule::when($client->exists , 'sometimes') ,'required' ],
                'address' => [Rule::when($client->exists , 'sometimes') ,'required'],
            ]
        )->validate();
    }
}

