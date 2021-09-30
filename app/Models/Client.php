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
        'adresse_client',
        'telephone_client',
        'date_abonnement',
        'duree',
        'date_reabonnement',
        'id_materiel',
        "id_user",
    ];

    public function materiels()
    {
        return $this->hasMany(Materiel::class);
    }
    public function messages()
    {
        return $this->belongsToMany(Message::class);
    }
    public function formules()
    {
        return $this->belongsToMany(Formule::class);
    }
    public function decodeurs()
    {
        return $this->belongsToMany(Decodeur::class);
    }
}
