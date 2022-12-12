<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting_level extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = [
    'name',
    'cashback_percent',
    'friend_percent',
    ];
}
