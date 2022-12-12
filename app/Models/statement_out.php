<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statement_out extends Model
{
    protected $guard='admin';
    protected $fillable = [
        'date_time',
        'bank_name',
        'bank_number',
        'info',
        'gateway_id',
        'uid',
        'status',
        

    ];
}
