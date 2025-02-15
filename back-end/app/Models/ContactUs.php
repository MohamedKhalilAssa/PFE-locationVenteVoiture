<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'object',
        'message',
        'is_answered',
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
