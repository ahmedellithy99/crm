<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
