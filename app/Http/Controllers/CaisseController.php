<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MessageController;
use App\Models\Formule;
use App\Models\Versement;
use App\Models\Versement_achats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Caisse;
use App\Models\User;
use App\Models\Reabonnement;
use Vonage\Response;

class CaisseController extends Controller
{
    public function index()
    {
//        $envoi = (new MessageController)->sendMessage("Verification","237679353205" );
        $totalcaisse = (new MessageController)->totalCaisse();
//        $restecaisse = (new MessageController)->resteCaisse();
//        $dejeconsomme = (new MessageController)->dejaConsomme();
        $versements = Versement::OrderBy('id_versement','DESC')
        ->get();
        $achats = Versement_achats::OrderBy('id_achat','DESC')
            ->get();
//        dd($totalcaise);
        $Caisse = Caisse::join('users','users.id','caisses.id_user')
            ->OrderBy('id_caisse','DESC')
            ->get();
        $totalVersement = (new VersementController)->totalVersement();
        $dejaUTilise = (new VersementController)->dejaUtilise();
        $resteVersement = (new VersementController)->resteVersement();
        $users = Versement::join('users','users.id','versements.id_user')->get();
        return view('caisse',compact('Caisse','users','totalVersement','resteVersement','dejaUTilise','totalcaisse','versements','achats'));
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
            'raison'=>'Reguler',
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
//    public function creditCaisse($montant,$raison)
//    {
//        $userid= Auth::user()->id;
//        $data = Caisse::create(['montant'=>$montant,
//            'raison'=>$raison,
//            'id_user'=>$userid,
//            'date_ajout'=>date("Y-m-d")
//        ]);
//        return $data;
//    }

    public function addVersementAchat(Request $request)
    {
        $request->validate([
            'montant_achat'=>'required'
        ]);
        $userid= Auth::user()->id;
        $data = Versement_achats::create(['montant_achat'=>$request->montant_achat,
            'description_achat'=>$request->description_achat,
            'id_user'=>$userid,
        ]);
//     dd($data);
        if ($data){
            $montant = $request->montant_achat *-1;
            $versementcaisse = $this->creditCaisse($data->id,'ACHAT',$montant);
            return  redirect()->back()->with('info', "Enregistré avec succès.");
        }else{
            return  redirect()->back()->with('danger', "Echec lors de l'enregistrement.");
        }

    }
    public function EditVersementAchat(Request $request)
    {
        $request->validate([
            'montant_achat'=>'required',
            'id_achat'=>'required'
        ]);
        $userid= Auth::user()->id;
        $data = Versement_achats::where('id_achat',$request->id_achat)->update(['montant_achat'=>$request->montant_achat,
            'description_achat'=>$request->description_achat,
            'id_user'=>$userid,
        ]);
        $editCaisse = $this->updateInCaisse($request->id_achat,'ACHAT',$request->montant_achat);
        return  redirect()->back()->with('info', "Enregistré avec succès.");
    }

    public function deleteVersementAchat($id_achat)
    {
        $userid= Auth::user()->id;
        $data = Versement_achats::where('id_achat',$id_achat)->delete();
        $deletecaisse = $this->removerFromCaisse($id_achat,'ACHAT');
        return  redirect()->back()->with('info', "Supprimé avec succès.");

//        return Response()->json($data);
    }

    public function creditCaisse($id,$operation,$montant){
        $caisse = 0;
        $userid= Auth::user()->id;
        if (!empty($id) && !empty($operation) && !empty($montant)){
            switch ($operation){
                case 'ACHAT':
//                    Caisse::create(['montant'=>$montant, 'raison'=>'Achat kits', 'id_user'=>$userid, 'date_ajout'=>date("Y-m-d"),'id_achat'=>$id]);
                    $caisse =Caisse::create(['montant'=>$montant, 'raison'=>'Achat kits', 'id_user'=>$userid, 'date_ajout'=>date("Y-m-d"),'id_achat'=>$id]);
                    break;
                case 'VERSEMENT':
                    $caisse =Caisse::create(['montant'=>$montant, 'raison'=>'Versement', 'id_user'=>$userid, 'date_ajout'=>date("Y-m-d"),'id_versement'=>$id]);
                    break;
                case 'REABONNEMENT':
                    $caisse =Caisse::create(['montant'=>$montant, 'raison'=>'Reabonnement', 'id_user'=>$userid, 'date_ajout'=>date("Y-m-d"),'id_reabonnement'=>$id]);
                    break;
                case 'ABONNEMENT':
                    $caisse =Caisse::create(['montant'=>$montant, 'raison'=>'Abonnement', 'id_user'=>$userid, 'date_ajout'=>date("Y-m-d"),'id_abonnement'=>$id]);
                    break;
                case 'UPGRADE':
                    $caisse =Caisse::create(['montant'=>$montant, 'raison'=>'Upgrade', 'id_user'=>$userid, 'date_ajout'=>date("Y-m-d"),'id_upgrade'=>$id]);
                    break;
                case 'DECODEUR':
                    $caisse =Caisse::where('id_decodeur',$id)->update(['montant'=>($montant)]);
                    break;
                default:
                    return  redirect()->back()->with('danger', "Erreur l'action aucune action spécifiée.");
                    break;

            }
        }else{
            return  redirect()->back()->with('danger', "Erreur l'action n'a pas été effectuée.");

        }
        return $caisse;
    }


    public function updateInCaisse($id,$operation,$montant){
        $caisse = 0;
        if (!empty($id) && !empty($operation)){
            switch ($operation){
                case 'ACHAT':
                    $caisse =Caisse::where('id_achat',$id)->update(['montant'=>($montant*-1)]);
                    break;
                case 'VERSEMENT':
                    Caisse::where('id_versement',$id)->update(['montant'=>($montant*-1)]);
                    break;
                case 'REABONNEMENT':
                    $caisse =Caisse::where('id_reabonnement',$id)->update(['montant'=>($montant)]);
                    break;
                case 'ABONNEMENT':
                    $caisse =Caisse::where('id_abonnement',$id)->update(['montant'=>($montant)]);
                    break;
                case 'UPGRADE':
                    $caisse =Caisse::where('id_upgrade',$id)->update(['montant'=>($montant)]);
                    break;
                case 'DECODEUR':
                    $caisse =Caisse::where('id_decodeur',$id)->update(['montant'=>($montant)]);
                    break;
                default:
                    return  redirect()->back()->with('danger', "Erreur l'action aucune action spécifiée.");
                    break;

            }
        }else{
            return  redirect()->back()->with('danger', "Erreur l'action n'a pas été effectuée.");

        }
        return $caisse;
    }

    public function removerFromCaisse($id,$operation){
        $caisse = 0;
        if (!empty($id) && !empty($operation)){
            switch ($operation){
                case 'ACHAT':
                    $caisse =Caisse::where('id_achat',$id)->delete();
                break;
                case 'VERSEMENT':
                    Caisse::where('id_versement',$id)->delete();
                break;
                case 'REABONNEMENT':
                    $caisse =Caisse::where('id_reabonnement',$id)->delete();
                break;
                case 'ABONNEMENT':
                    $caisse =Caisse::where('id_abonnement',$id)->delete();
                break;
                case  'UPGRADE':
                    $caisse =Caisse::where('id_upgrade',$id)->delete();
                break;
                case 'DECODEUR':
                    $caisse =Caisse::where('id_decodeur',$id)->delete();
                break;
                default:
                    return  redirect()->back()->with('danger', "Erreur l'action aucune action spécifiée.");
                break;

            }
        }else{
            return  redirect()->back()->with('danger', "Erreur l'action n'a pas été effectuée.");

        }
        return $caisse;
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
