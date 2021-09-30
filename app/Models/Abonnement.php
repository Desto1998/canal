<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_client',
        'id_decodeur',
        'id_formule',
        'type_abonnement',
        'date_reabonnement',
        'duree',
        'date_echeance',
        'statut_abo',
        'id_user',
        ]
    ;
}
