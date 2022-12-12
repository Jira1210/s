<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partner_cash_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'getpartner_id',
        'amount',
        'percent',
        'commission',
        'partner_cash_id',
        'status',
        'type_Partner_commisson_id',
        ];
}
