<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class getpartner extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'partner_id',
        'status',
    ];
}
