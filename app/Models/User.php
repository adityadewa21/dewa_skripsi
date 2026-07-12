<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* ================= RELATIONS ================= */

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /* ================= HELPERS ================= */

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
