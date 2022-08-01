<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    const BEKLENIYOR = 2;
    const RED = 0;
    const ONAY = 1;

    protected array $status = [
        0 => 'Reddedildi',
        1 => 'Onaylandı',
        2 => 'Bekleniyor'
    ];

    protected $table = 'points';

    protected $fillable = [
        'user_id',
        'point',
        'status'
    ];

    public function scopeWaiting($query) {
        return $query->where('points.status',self::BEKLENIYOR);
    }

    public function scopeAnswered($query) {
        return $query->where(function ($q) {
            $q->where('points.status', '=', self::ONAY)
                ->orWhere('points.status', '=', self::RED);
        });
    }

    public function pointStatus($statusId) {
        return $this->status[$statusId];
    }

    public function scopePointUser($query) {
        return $query->join('users','users.id','=','points.user_id');
    }
}
