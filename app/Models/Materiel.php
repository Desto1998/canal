<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;

class Materiel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_materiel',
        'prix_materiel',
        'quantite',
        'date_livaison',
        "id_user",
    ];
//    public function client()
//    {
//        return $this->belongsTo(Client::class);
//    }
    public function decodeurs()
    {
        return $this->belongsToMany(Decodeur::class);
    }
}
