<?php

namespace App\Models;

use App\Models\Modele;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marque extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'image'
    ];

    public function modeles()
    {
        return $this->hasMany(Modele::class);
    }
    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }
}
