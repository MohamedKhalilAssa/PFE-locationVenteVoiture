<?php

namespace App\Models;

use App\Models\Marque;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modele extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nom',
        'marque_id', 'image'
    ];
    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }
}
