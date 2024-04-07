<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class couleursVoiture extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nom',
        'Hexadecimal',
    ];

    public function voitures()
    {
        return $this->hasMany(Annonce::class, 'couleur_id');
    }
}
