<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versement extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference',
        'montant_versement',
        'description',
        'id_user',
    ];
}
