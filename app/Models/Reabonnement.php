<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reabonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_client',
        'id_decodeur',
        'id_formule',
        'type_reabonement',
        'date_reabonnement',
        'id_user',
    ];

}
