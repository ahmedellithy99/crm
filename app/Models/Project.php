<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS = ['open', 'in progress', 'blocked', 'cancelled', 'completed'];

    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks():HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function image():MorphOne
    {
        return $this->morphOne(Image::class , 'imageable');
    }

    public function scopeFilterStatus($query , $status )
    {
        return $query->when($status , fn($query) => $query->when($status === 'all' , 
        fn($query) => $query->whereIn('status' , Project::STATUS), 
        fn($query) => $query->where('status' , $status))
    );
    }
}
