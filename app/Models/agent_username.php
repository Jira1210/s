<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agent_username extends Model
{
    use HasFactory;
    protected $fillable = [
        'username_agent',
        'password',
        'agent_id',
        'user_id',
    ];
}
