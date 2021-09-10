<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\ClientDecodeur;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Materiel;
use App\Models\Reabonnement;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function dashboard()
    {
        $allFormules = Formule::all();
        $decodeurs= Decodeur::all();
        $reabonnements = Reabonnement::all();
        $clients = Client::All();
        $decodeuroccupe = ClientDecodeur::all();
        $materiels= Materiel::all();
        $users = User::all();
        $caisse = Caisse::all();
        $totalCaisse  = (new MessageController)->totalCaisse();
        $statutcaisse = (new MessageController)->resteCaisse();
//        $difference = (new MessageController)->resteCaisse();
        $consommeCaisse = (new MessageController)->dejaConsomme();
        $clientnouveaux = $this->nouveauClient();
        $clientperdu = $this->clientPerdu();
        $bientotaterme = $this->bientATerme();
        return view('dashboard',compact('allFormules','reabonnements','decodeurs','clients',
            'decodeuroccupe','materiels','materiels','users','caisse','totalCaisse','statutcaisse','consommeCaisse'
            ,'clientnouveaux','clientperdu','bientotaterme'
        ));
    }

    public function nouveauClient(){
        $envoi = (new MessageController)->sendMessage("237679353205","" );

        $userid= Auth::user()->id;
        $data = Decodeur::join('client_decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
//         ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('formules','client_decodeurs.id_formule','formules.id_formule')
            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement','>=',date('Y-m-d'))
//         ->where('client_decodeurs.id_user',$userid)
            ->get();
        return $data;
    }

    public function clientPerdu(){
//     $envoi = (new MessageController)->sendMessage($message,$request->telephone_client );
        $userid = Auth::user()->id;
        $date = date("Y-m-d");
        $data = Decodeur::join('client_decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
            ->join('formules','client_decodeurs.id_formule','formules.id_formule')
            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement','<=',date('Y-m-d'))
//         ->where('client_decodeurs.id_user',$userid)
            ->get();
        return $data;
    }

    // abonne bienetot a terme dans 3
    public function bientATerme(){

        $date_reabonnement = date_format(date_add(date_create(date("Y-m-d")),date_interval_create_from_date_string("3 days")),'Y-m-d');

        $data = ClientDecodeur::join('clients','clients.id_client','client_decodeurs.id_client')
//            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement','<=',$date_reabonnement)
            ->get();
        return $data;
    }

    public function rechercherGlobal(Request  $request){
        dd($request);exit();
    }
}
