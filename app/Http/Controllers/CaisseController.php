<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MessageController;
use App\Models\Formule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Caisse;
use App\Models\User;
use App\Models\Reabonnement;

class CaisseController extends Controller
{
    public function index()
    {
//        $envoi = (new MessageController)->sendMessage("Verification","237679353205" );
        $totalcaisse = (new MessageController)->totalCaisse();
        $restecaisse = (new MessageController)->resteCaisse();
        $dejeconsomme = (new MessageController)->dejaConsomme();
//        dd($totalcaise);
        $Caisse = Caisse::join('users','users.id','caisses.id_user')
//            ->where('client_decodeurs.id_client',$id_client)
            ->get();
        return view('caisse',compact('Caisse','totalcaisse','restecaisse','dejeconsomme'));
    }

    public function get($id_caisse)
    {
        $totalcaisse = (new MessageController)->totalCaisse();
        $restecaisse = (new MessageController)->resteCaisse();
        $dejeconsomme = (new MessageController)->dejaConsomme();

        $Caisse = Caisse::join('users','users.id','caisses.id_user')
//            ->where('client_decodeurs.id_client',$id_client)
            ->get();
        $datas = Caisse::where('id_caisse',$id_caisse)->get();
        //dd($datas);
        return view('caisse',compact('datas','Caisse','totalcaisse','restecaisse','dejeconsomme'));
    }

    public function update(Request $request)
    {
        $userid= Auth::user()->id;

        $data = Caisse::where('id_caisse',$request->id_caisse)->update(['montant'=>$request->montant,
            'id_user'=>$userid
        ]);
        session()->flash('message', "Modifié avec succès.");
        return  redirect(route("caisse"))->with('info', "Modifié avec succès.");
    }
    public function store(Request $request)
    {
        $userid= Auth::user()->id;
        $data = Caisse::create(['montant'=>$request->montant,
            'id_user'=>$userid,
            'date_ajout'=>date("Y-m-d")
        ]);
        session()->flash('message', "Enregistré avec succès.");
        return  redirect()->back()->with('info', "Enregistré avec succès.");
    }
    public function delete($id){

        $data = Caisse::where('id_caisse',$id)->delete();
        $userid= Auth::user()->id;
        session()->flash('message', "Supprimé avec succès.");
        return  redirect()->back()->with('info', "Supprimé avec succès.");
    }

    public function debitCaisse($montant,$raison)
    {
        $userid= Auth::user()->id;
        $data = Caisse::create(['montant'=>$montant,
            'raison'=>$raison,
            'id_user'=>$userid,
            'date_ajout'=>date("Y-m-d")
        ]);
        return $data;
    }
    public function creditCaisse($montant,$raison)
    {
        $userid= Auth::user()->id;
        $data = Caisse::create(['montant'=>$montant,
            'raison'=>$raison,
            'id_user'=>$userid,
            'date_ajout'=>date("Y-m-d")
        ]);
        return $data;
    }
}
