<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom_client',
        'prenom_client',
        'num_abonne',
        'adresse_client',
        'telephone_client',
        'date_abonnement',
        'duree',
        'date_reabonnement',
        'id_formule',
        'id_materiel',
        'id_decodeur',
    ];

    public function materiels()
    {
        return $this->hasMany(Materiel::class);
    }
    public function messages()
    {
        return $this->belongsToMany(Message::class);
    }
    public function formule()
    {
        return $this->hasOne(Formule::class);
    }
    public function decodeur()
    {
        return $this->hasOne(Decodeur::class);
    }
}
