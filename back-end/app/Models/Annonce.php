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
    protected $fillable = [
        'marque_id',
        'modele_id',
        'couleur_id',
        'ville_id',
        'owner_id',
        'type_annonce',
        'statut_annonce',
        'etat',
        'carburant',
        'kilometrage',
        'annee_fabrication',
        'options',
        'prix_vente',
        'prix_location',
        'disponibilite_vente',
        'disponibilite_location',
        'image',
        'description',
        'titre',
    ];


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
