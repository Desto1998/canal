<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\Message;
use App\Models\User;
use App\Models\Versement;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        $messages = Message::all();
//        $versements = Versement::join('users','users.id','versements.id_user')->get();
        $versements = Versement::all();
        $users = Versement::join('users','users.id','versements.id_user')->get();
        $totalVersement = (new VersementController)->totalVersement();
        $dejaUTilise = (new VersementController)->dejaUtilise();
        $resteVersement = (new VersementController)->resteVersement();
//
        return view('setting.index', compact('users','totalVersement','dejaUTilise','resteVersement','versements','messages','fournisseurs'));
    }
    //
}
