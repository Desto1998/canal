<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decodeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_decodeur',
        'quantite',
        'prix_decodeur',
        'quantite_stock',
        'date_livaison',
        'id_materiel',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function materiels()
    {
        return $this->hasMany(Materiel::class);
    }
}
