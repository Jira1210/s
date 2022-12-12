<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_friend_commission extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'detail'
    ];
}
