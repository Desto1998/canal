<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_fr',
        'email_fr',
        'phone_fr',
        'adresse_fr',
        'description_fr',
        'id_user',
    ];
}
