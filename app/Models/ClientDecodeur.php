<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDecodeur extends Model
{
    use HasFactory;
    protected $fillable = [
        "id_user",
        'id_decodeur',
        'id_client',
        'id_formule',
        'date_reabonnement',
        'date_abonnement',
    ];

}
