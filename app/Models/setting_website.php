<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting_website extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = [
    'title',
    'detail',
    'notify',
    'line',
    'auto_withdraw_max',
    'withdraw_min',
    'withdraw_max',
    'withdraw_count_max',
    'withdraw_sum_max',
    'turnover_clear',
    'friend_default',
    'friend_status',
    'cashback_default',
    'cashback_status',
    'turnover_status',
    'status',
    ];
}
