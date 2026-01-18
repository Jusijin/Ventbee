<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use App\Models\Notification; <--- HAPUS baris ini jika tidak dipakai lagi
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Transaction;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable; // Pastikan 'Notifiable' tetap ada di sini

    protected $fillable = [
        'name', 'email', 'password', 'profile_photo',
        'birth_date', 'gender', 'phone', 'address', 'role', 'locale',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI LAIN BIARKAN SAJA ---
    
    public function eventsCreated(){
        return $this->hasMany(Event::class, 'created_by');
    }

    public function joinedEvents(){
        return $this->hasMany(EventParticipant::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    /* --- PENTING: BAGIAN INI DIHAPUS ---
       public function notifications(){
           return $this->hasMany(Notification::class);
       } 
       Kita hapus karena trait 'Notifiable' di atas sudah otomatis menyediakannya.
    */

    public function events(){
        return $this->belongsToMany(
            Event::class,
            'event_participants',
            'user_id',
            'event_id'
        )->withPivot('status', 'joined_at')->withTimestamps();
    }
}