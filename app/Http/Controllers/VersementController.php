<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Formule;
use App\Models\Versement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VersementController extends Controller
{
//    public function index()
//    {
////        $envoi = (new MessageController)->sendMessage("Verification","237679353205" );
//        $totalcaisse = (new MessageController)->totalCaisse();
//        $restecaisse = (new MessageController)->resteCaisse();
//        $dejeconsomme = (new MessageController)->dejaConsomme();
////        dd($totalcaise);
//        $versements = Versement::join('users','users.id','versements.id_user')
////            ->where('client_decodeurs.id_client',$id_client)
//            ->get();
//        return view('caisse',compact('versements','totalcaisse','restecaisse','dejeconsomme'));
//    }

    public function update(Request $request)
    {
        $request->validate([
            'montant_versement'=>'required',
            'id_versement'=>'required',
        ]);
        $userid= Auth::user()->id;

        $data = Versement::where('id_versement',$request->id_versement)
            ->update([
                'montant_versement'=>$request->montant_versement,
                'id_user'=>$userid,
                'description'=> $request->descriptioon
        ]);
        if ($data){
            session()->flash('message', "Enregistré avec succès.");
            return  redirect()->back()->with('info', "Enregistré avec succès.");
        }else{
            return  redirect()->back()->with('info', "Echec lors de l'enregistrement.");
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'montant_versement'=>'required',
        ]);
        $userid= Auth::user()->id;
        $data = Versement::create([
            'montant_versement'=>$request->montant_versement,
            'description'=>$request->description,
            'id_user'=>$userid,
        ]);
        if ($data){
            session()->flash('message', "Enregistré avec succès.");
            return  redirect()->back()->with('info', "Enregistré avec succès.");
        }else{
            return  redirect()->back()->with('info', "Echec lors de l'enregistrement.");
        }

    }
    public function delete($id){

        $data = Versement::where('id_versement',$id)->delete();
        $userid= Auth::user()->id;
        if ($data){
            session()->flash('message', "Supprimé avec succès.");
            return  redirect()->back()->with('info', "Supprimé avec succès.");
        }else{
            return  redirect()->back()->with('info', "Echec de suppression.");
        }

    }

    public function totalVersement(){
        $totat = Versement::sum("montant_versement");
        return $totat;
    }
    public function dejaUtilise(){
        $reste= Formule::join('reabonnements','formules.id_formule','reabonnements.id_formule')
            ->sum(\DB::raw('formules.prix_formule * reabonnements.duree'));
        return $reste;

    }
    public function resteVersement(){
        $diference = $this->totalVersement() - $this->dejaUtilise();
        return $diference;

    }
}
