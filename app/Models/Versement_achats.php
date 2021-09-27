<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versement_achats extends Model
{
    use HasFactory;
    protected $fillable = ['montant_achat','description_achat','id_user'];
}
