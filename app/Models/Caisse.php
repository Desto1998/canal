<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant','raison','id_reabonnement','id_abonnement',
        "id_user","date_ajout",'id_versement','id_upgrade','id_achat',
        'id_decodeur','id_materiel'
    ];
}
