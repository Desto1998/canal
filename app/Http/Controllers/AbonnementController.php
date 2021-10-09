<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Client;
use App\Models\ClientDecodeur;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Type_operation;
use App\Models\Upgrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\AbstractList;
use DateInterval;
use DateTime;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;
use App\Models\Reabonnement;
use App\Models\User;
use App\Models\Materiel;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Expr\Cast;

class AbonnementController extends Controller
{
    public function upgradeAbonnement(Request $request)
    {
        $request->validate([
            'formule' => 'required',
            'id_abonnement' => 'required',
            'id_formule' => 'required',
            'id_decodeur' => 'required',
            'id_client' => 'required',
        ]);
        $id_client = $request->id_client;
        $data = Client::find($id_client);
        $dt = Abonnement::where('id_client', $request->id_abonnement)->get();
        $formule = Formule::where('id_formule', $request->id_formule)->get();
        $formul = Formule::where('nom_formule', $request->formule)->get();
        $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();
        $difference = $formul[0]->prix_formule - $formule[0]->prix_formule;
        if ($difference > 0) {
            if ($statutcaisse < $difference) {
                session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');

                return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');
            }
        }
        $userid = Auth::user()->id;
        $clientdeco = ClientDecodeur::where('id_decodeur',$request->id_decodeur)->get();
        if ($clientdeco){
            $data->num_abonne = $clientdeco[0]->num_abonne;
        }
        $statut = 0;
        if ($request->type == 1) {
            $statut = 1;
        }
        $upgrade = Upgrade::create([
            'id_oldformule' => $request->id_formule,
            'id_newformule' => $id_formule,
            'montant_upgrade' => $data->duree * $difference,
            'type_upgrade' => $request->type,
            'date_upgrade' => date('Y-m-d'),
            'id_reabonnement' => 0,
            'id_abonnement' => $request->id_abonnement,
            'statut_upgrade' => $statut,
            'id_user' => $userid,
        ]);

        $data_pdf = new Array_();
        $data_pdf->nom_client = $data->nom_client;
        $data_pdf->prenom_client = $data->prenom_client;
        $data_pdf->num_abonne = $data->num_abonne;
        $data_pdf->telephone_client = $data->telephone_client;
        $data_pdf->dureeA = 0;
        $data_pdf->dureeR = 0;
        $data_pdf->dureeU = $data->duree;
//        $data_pdf->dureeU = $data->duree;
        $data_pdf->num_decodeur = $request->num_decodeur;
        $data_pdf->nom_formule = $request->formule;
        $data_pdf->prix_formuleU = $difference;
        $data_pdf->prix_formuleR = 0;
        $data_pdf->prix_formuleA = 0;
        $data_pdf->total = $data->duree * $difference;
        $data_pdf->date_reabonnement = $request->date_reabonnement;
        $data_pdf->date_abonnement = "";

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = "";
        $data_message->dateecheance = $request->date_reabonnement;
        $data_message->montant = $data->duree * $difference;
        $data_message->id_client = $id_client;

        if ($upgrade) {
            $storeCaisse = (new CaisseController)->creditCaisse($upgrade->id_upgrade, 'UPGRADE', $data_pdf->total);

            $message_con = '';
            $message = $data->nom_client . " Mis à jour de la formule réussi ! Formule: " . $request->formule . ", expire le: " . $data->date_reabonnement . ".";
            $envoi = (new MessageController)->prepareMessage($data_message, 'REABONNEMENT');

        }

        $balance = (new MessageController)->getSMSBalance();
        $pdf = (new PDFController)->createPDF($data_pdf, 'UPGRADE');
        session()->flash('message', "L'upgrate du client a reussi. Solde SMS: " . $balance);
        return redirect()->route('upgrader')->with('info', "L'upgrate du client a reussi. Solde SMS: " . $balance);
    }

    public function mesAbonnements()
    {
        $userid = Auth::user()->id;
        $data = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
            ->join('clients', 'abonnements.id_client', 'clients.id_client')
            ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
//            ->join('decodeurs', 'decodeurs.id_decodeur', 'decodeurs.id_decodeur')
//            ->where('abonnements.created_at','LIKE', "{$date}%")
            ->where('abonnements.id_user', $userid)
            ->OrderBy('id_abonnement','DESC')
            ->get();
        return view("abonnement.mes_abonnements", compact('data'));
    }

    public function mesAbonnementsjour()
    {
        $userid = Auth::user()->id;
        $data = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('formules', 'client_decodeurs.id_formule', 'formules.id_formule')
            ->join('clients', 'clients.id_client', 'client_decodeurs.id_client')
            ->where('client_decodeurs.date_abonnement', date('Y-m-d'))
            ->where('client_decodeurs.id_user', $userid)
            ->get();
        $date=date('Y-m-d');
        $data = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
            ->join('clients', 'abonnements.id_client', 'clients.id_client')
            ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
//            ->join('decodeurs', 'decodeurs.id_decodeur', 'decodeurs.id_decodeur')
            ->where('abonnements.created_at','LIKE', "{$date}%")
            ->where('abonnements.id_user', $userid)
            ->OrderBy('id_abonnement','DESC')
            ->get();
        //     dd($data);exit();
        return view("abonnement.abonnementsjours", compact('data'));
    }

    public function deleteAbonne(Request $request)
    {
        $decodeur = Abonnement::where('id_abonnement', $request->id_abonnement)->get();
        $abonnement = Abonnement::where('id_abonnement', $request->id_abonnement)->delete();
        if ($abonnement) {
            $romeveFromcaisse = (new CaisseController)->removerFromCaisse($request->id_abonnement,'ABONNEMENT');

            $delete = ClientDecodeur::where('id_decodeur', $decodeur[0]->id_decodeur)->delete();
        }
//        $deletec = Client::where('id_client', $id)->delete();
        return Response()->json($delete);
    }

    public function upAbonnement($id_client, $id_abonnement)
    {

        $abonnement = Abonnement::where('id_abonnement', $id_abonnement)->get();
        $decodeur = Decodeur::where('id_decodeur', $abonnement[0]->id_decodeur)->get();
        $decos = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
            ->where('client_decodeurs.id_client', $abonnement[0]->id_decodeur)
            ->get();
        return view('upgrade.upgradeabonnement', [
            'datas' => Client::find($id_client),
            'abonnement' => Abonnement::where('id_abonnement', $id_abonnement)->get(),
            'formule' => Formule::where('id_formule', $abonnement[0]->id_formule)->get(),
            'decodeur' => Decodeur::where('id_decodeur', $abonnement[0]->id_decodeur)->get(),
            'decos' => $decos
        ]);
    }
    public function deleteAbonnement(Request $request){
        $delete = Abonnement::where('id_abonnement',$request->id)->delete();
        $romeveFromcaisse = (new CaisseController)->removerFromCaisse($request->id,'ABONNEMENT');
        Response()->json($delete);
    }

    public function recoverReabonne(Request $request)
    {
        $id = $request->id;
        $userid = Auth::user()->id;
        $abo = Abonnement::where('id_abonnement',$id)->get();
        $montant = 0;
        if ($abo){
            $formul = Formule::where('id_formule',$abo[0]->id_abonnement)->get();
            if ($formul){
                $montant = $formul[0]->prix_formule*$abo[0]->duree;
            }
        }
        $save = Type_operation::create([
            'id_reabonnement'=>0,
            'id_abonnement'=>$id,
            'id_upgrade'=>0,
            'date_ajout'=>date('Y-m-d'),
            'id_user'=>$userid,
            'montant'=>$montant,
            'type'=>1,
            'operation'=>'ABONNEMENT',
        ]);
        if ($save){
            $recover = Abonnement::where('id_abonnement', $id)->update(['type_abonnement' => 1]);

        }

        return Response()->json($recover);
    }
    //
}
