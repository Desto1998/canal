<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_formule',
        'prix_formule',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
