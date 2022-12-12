<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deposit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'condition_id',
        'amount',
        'bonus',
        'gateway_id',
        'datetime',
        'admin_id',
        'type',
        'status',

    ];
}
