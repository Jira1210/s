<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transfer_game extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'credit_before',
        'credit_after',
        'credit',
        'type',
        'status',
        ];
}
