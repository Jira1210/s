<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_bank extends Model
{
    //protected $guard='admin';
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = [
        'typebank_name'
    ];
}
