<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_operation extends Model
{
    use HasFactory;
    protected $fillable = [
        'operation',
        'type',
        'id_reabonnement',
        'id_abonnement',
        'id_upgrade',
        'date_ajout',
        'montant',
        'id_user',
    ];
}
