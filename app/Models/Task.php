<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'project_id',
        'deadline',
        'status'
    ];

    public const STATUS = ['open', 'in progress', 'pending', 'waiting client', 'blocked', 'closed'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    public function scopeFilterStatus($query , $status )
    {
        return $query->when($status , fn($query) => $query->when($status === 'all' , 
        fn($query) => $query->whereIn('status' , Task::STATUS), 
        fn($query) => $query->where('status' , $status))
    );
    }
    
}
