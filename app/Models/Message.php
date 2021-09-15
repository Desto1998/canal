<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'titre_sms',
        'type_sms',
        'description_sms',
    ];


    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}

