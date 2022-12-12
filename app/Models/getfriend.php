<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class getfriend extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_child_id',
        'user_parent_id',
        'status',
    ];
}
