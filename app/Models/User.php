<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function folders() {
        return $this->hasMany(Folder::class, 'created_by');
    }

    public function activityLogs() {
        return $this->hasMany(ActivityLog::class);
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }
}