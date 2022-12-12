<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transfer_cash_Sadmin extends Model
{
    use HasFactory;
    protected $fillable = 
    [ 
        'bank_name', 
        'bank_number', 
        'amount', 
        'status', 
        'info', 
        'admin_id', 
    ];
}
