<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upgrade extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_oldformule',
        'id_newformule',
        'montant_upgrade',
        'type_upgrade',
        'date_upgrade',
        'id_reabonnement',
        'id_abonnement',
        'statut_upgrade',
        'id_user',
    ];
}
