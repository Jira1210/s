<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class withdraws extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_number',
        'user_name',
        'amount',
        'admin_id',
        'type',
        'status',
        'gateway_id',
        'info',
        'condition_id',
    ];
    
}
