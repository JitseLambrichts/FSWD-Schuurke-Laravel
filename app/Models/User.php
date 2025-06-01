<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array {
        return [
            'password' => 'hashed',
        ];
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function reserveringen() {
        return $this->hasMany(Reservatie::class, 'user_id')
            ->orderBy('datum', 'asc')
            ->orderBy('tijdstip', 'asc');
    }
}
