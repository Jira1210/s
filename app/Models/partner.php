<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partner extends Model
{
    use HasFactory;
    protected $fillable = [
    'id',
    'percent',
    'username',
    'name',
    'status',
    'partner_wallet',
    'partner_link',
    ];
}
