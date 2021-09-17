<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message_Envoye extends Model
{
    protected $table='message_envoyes';
    use HasFactory;
    protected $fillable = [
        'message',
        'nom_client',
        'id_message',
        'id_client',
        'telephone_client',
        'description_sms',
        'statut',
        'quantite',
        'id_user',
        'description_sms',
    ];

}
