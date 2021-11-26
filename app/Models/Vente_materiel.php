<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente_materiel extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant_vente',
        'type_vente',
        'date_vente',
        'id_stock',
        'id_client',
        'id_user',
        'created_at',
        'updated_at',
    ];
}
