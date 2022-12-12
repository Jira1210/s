<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promotion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'detail',
        'percentage',
        'pro_turnover',
        'pro_turnover',
        'min_deposit',
        'max_per_bill',
        'max_amount_sum',
        'max_count_bill',
        'type',
        'status',
    ];
}
