<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    const VIP = 1;
    const RISKLI = 0;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    public function scopeCurrentUser() {
        return $this->find(session('user'));
    }

    public function scopeCurrentUserId() {
        return session('user');
    }

    public function points() {
        return $this->hasMany(Point::class,'user_id')
            ->select('points.*');
    }
}
