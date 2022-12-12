<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class login_log_user extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'device',
        'ip_address'

    ];
}
