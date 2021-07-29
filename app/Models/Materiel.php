<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;

class Materiel extends Model
{
    use HasFactory;

    protected $fillable = [
        'prix_materiel',
        'quantite',
        'quantite_stock',
        'date_livaison',
        'type_id',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function decodeur()
    {
        return $this->belongsTo(Decodeur::class);
    }
}
