<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'url',
        'visit_time',
        'action',
        'referrer',
    ];
}
