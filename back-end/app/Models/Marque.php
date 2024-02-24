<?php

namespace App\Models;

use App\Models\Modele;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marque extends Model
{
    use HasFactory;

    public function modeles()
    {
        return $this->hasMany(Modele::class);
    }
}
