<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\EventParticipant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_id',
        'event_name',
        'description',
        'location',
        'date',
        'total_quota',
        'quota_taken',
        'registration_open',
        'registration_close',
        'status',
        'role',
        'created_by'
    ];

    protected $casts = [
        'date' => 'datetime',
        'registration_open' => 'datetime',
        'registration_close' => 'datetime',
    ];
    
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function creator(){
        return $this->belongsTo(User::Class, 'created_by');
    }

    public function participants(){
        return $this->belongsToMany(User::class, 'event_participants')
        ->withPivot(['status', 'joined_at'])
        ->withTimestamps();
    }
}
