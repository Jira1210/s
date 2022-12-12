<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = [
        'bank_name',
        'type_bank_id',
        'bank_logo',
    ];
}
