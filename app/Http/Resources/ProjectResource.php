<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    public function toArray(Request $request): array
    {
        return 
            [   
                
                'users' => UserResource::collection($this->users),
                'client' => ClientResource::make($this->client),
                // 'tasks' => TaskResource::make($this->task),
                
                $this->merge(Arr::except(parent::toArray($request), ['deleted_at' , 'updated_at' , 'created_at' ,'tasks' ])),
                
            
            ];

}
}
