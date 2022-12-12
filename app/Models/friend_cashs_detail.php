<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friend_cashs_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'getfriend_id',
        'amount',
        'percent',
        'commission',
        'friend_cash_id',
        'status',
        'type_friend_commisson_id',
    ];

}
