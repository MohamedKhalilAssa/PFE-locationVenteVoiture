<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class couleursVoiture extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
    ];

    public function voitures()
    {
        return $this->hasMany(Annonce::class, 'couleur_id');
    }
}
