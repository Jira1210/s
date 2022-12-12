<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class condition extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'promotion_id',
        'activity_id',
        'status',
        'other',
        'user_id',
        'turn_before',
        'turn_now',
        'turn_con',
        'turn_before_datetime',
        'info',
        'wheel_id'
    ];
}
