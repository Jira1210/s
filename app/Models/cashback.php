<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cashback extends Model
{
    use HasFactory;
    protected $fillable = [
    'date_start',
    'date_end',
    'status',
    'amount',
    'date_topay'
    ];
}
