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
        'date_livaison',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function materiels()
    {
        return $this->belongsToMany(Materiel::class);
    }
}
