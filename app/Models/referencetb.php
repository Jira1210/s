<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referencetb extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'status',
    ];
}
