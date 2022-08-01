<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    const BEYAZ = 1;

    const KIRMIZI = 2;

    const SARI = 3;

    protected $table = 'templates';

    protected $fillable = [
        'color'
    ];
}
