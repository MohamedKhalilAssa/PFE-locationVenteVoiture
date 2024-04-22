<?php

namespace App\Models;

use App\Models\User;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\couleursVoiture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Annonce extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function modele()
    {
        return $this->belongsTo(Modele::class, 'modele_id');
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class, 'marque_id');
    }
    public function couleur()
    {
        return $this->belongsTo(couleursVoiture::class);
    }
    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id');
    }
}
