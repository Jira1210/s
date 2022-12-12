<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'image',
        'detail',
        'act_turnover',
        'type',
        'status',
    ];
}
