<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Reabonnement;
use App\Models\Type_operation;
use App\Models\Upgrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateInterval;
use DateTime;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Message;
use App\Models\ClientDecodeur;
use App\Models\User;
use App\Models\Materiel;
use phpDocumentor\Reflection\Types\AbstractList;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Expr\Cast;

class UpgradeController extends Controller
{
    public function viewModif()
    {
        $userid = Auth::user()->id;
        $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->where('client_decodeurs.date_reabonnement', '>=', date('Y-m-d'))
            ->get();
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'reabonnements.id_decodeur', 'client_decodeurs.id_decodeur')
            ->where('reabonnements.date_echeance', '>=', date('Y-m-d'))
//            ->where('clients.id_user', $userid)
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get()
        ;
        $reabonnement = Reabonnement::all();
        $clients = Client::all();
        $formules = Formule::all();
        $decodeurCleint = ClientDecodeur::join('decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
            ->get()
        ;
        return view("upgrade.upgrader", compact('data','decodeurCleint','formules','clients', 'reabonnement', 'clientdecodeur'));
    }

    public function allUpgrades()
    {
        $data = Upgrade::join('users', 'upgrades.id_user', 'users.id')
//            ->join('formules', 'formules.id_oldformule', 'upgrades.id_oldformule')
            ->OrderBy('id_upgrade', 'DESC')
            ->get();
        $formules = Formule::all();
        $reabonnements = Reabonnement::join('clients', 'clients.id_client', 'clients.id_client')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->get();
        $abonnements = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('clients', 'clients.id_client', 'clients.id_client')
            ->get();
        $messages = (new MessageController)->getStandart();
        return view('upgrade.upgrade-all', compact('data', 'formules', 'reabonnements', 'abonnements', 'messages'));
    }

    public function deleteUpgrade(Request $request)
    {
        $delete = Upgrade::where('id_upgrade', $request->id)->delete();
        $romeveFromcaisse = (new CaisseController)->removerFromCaisse($request->id, 'UPGRADE');
        Response()->json($delete);
    }


    public function recoverUpgrade(Request $request)
    {
        $id = $request->id_upgrade;
        $userid = Auth::user()->id;
        $up = Upgrade::where('id_upgrade', $id)->get();
        $montant = 0;
        $upgrade='';
        if ($up) {
            $montant = $up[0]->montant_upgrade;
        }
        $save = Type_operation::create([
            'id_reabonnement' => 0,
            'id_abonnement' => 0,
            'id_upgrade' => $id,
            'date_ajout' => date('Y-m-d'),
            'id_user' => $userid,
            'montant' => $montant,
            'type' => 1,
            'operation' => 'UPGRADE',
        ]);
        if ($save) {
            $upgrade = Upgrade::where('id_upgrade', $id)->update(['type_upgrade' => 1]);
            $storeCaisse = (new CaisseController)->creditCaisse($id, 'UPGRADE', $montant);
        }

        return Response()->json($upgrade);
    }

    public function addNew(Request $request)
    {
        $request->validate([
            'oldformule' => 'required',
            'newformule' => 'required',
            'duree' => 'required',
            'date_reabonnement' => 'required',
        ]);
        $userid = Auth::user()->id;
        $data = new Array_();
        $data->duree = $request->duree;
        $date_reabonnement = date_format(date_add(date_create("$request->date_reabonnement"), date_interval_create_from_date_string("$request->duree months")), 'Y-m-d');


        $date = new DateTime($date_reabonnement);
        $date->sub(new DateInterval("P{$request->duree}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
        $data->date_reabonnement = $date;
        $date_reabonnement = $data->date_reabonnement;
        $data->duree = $request->duree;

        $data->date_abonnement = $request->date_abonnement;
        $oldformule = Formule::where('id_formule', $request->oldformule)->get();
        $newformule = Formule::where('id_formule', $request->newformule)->get();
        if (isset($oldformule[0]) && isset($newformule[0])){
            $montant_upgrade = $newformule[0]->prix_formule - $oldformule[0]->prix_formule;
        }
        if (isset($request->check) && $request->check==1)
        {
//            dd($request);
            $request->validate([
                'id_decodeur' => 'required',
                'id_client' => 'required',
            ]);

            $id_client = $request->id_client;
            $client = Client::where('id_client',$request->id_client)->get();
            $decodeur = Decodeur::where('id_decodeur',$request->id_decodeur)->get();
            $dc = ClientDecodeur::where('id_decodeur',$request->id_decodeur)->get();
//            $clientdecodeur = ClientDecodeur::where('id_decodeur',$request->id_decodeur)->get();
            if (isset($decodeur[0])){
                $num_decodeur = $decodeur[0]->num_decodeur;
            }

            $data->nom_client = $client[0]->nom_client;
            $data->prenom_client = $client[0]->prenom_client;
            $data->num_abonne = $dc[0]->num_abonne;
            $data->telephone_client = $client[0]->telephone_client;
            $data->num_decodeur = $decodeur[0]->num_decodeur;
            $data->id_materiel = $request->id_decodeur;

        }else{
            $request->validate([
                'num_abonne' => 'required',
                'telephone_client' => 'required',
                'nom_client' => 'required',
                'num_decodeur' => 'required',
            ]);
            $checkclient = Client::where('telephone_client',$request->telephone_client)->get();
            $checkdecodeur = Decodeur::where('num_decodeur',$request->num_decodeur)->get();

//            dd($checkclient, $request);
            if (count($checkclient)>0)
            {
                return redirect()->back()->with('danger', 'Le client existe déja! Veillez sélectionner ou utiliser un autre numéro de télephone.');
            }
            if (count($checkdecodeur)>0)
            {
                return redirect()->back()->with('danger', 'Le décodeur est déja occupé par un qutre client.');
            }
            $data->nom_client = $request->nom_client;
            $data->prenom_client = $request->prenom_client;
            $data->adresse_client = $request->adresse_client;
            $data->num_decodeur = $request->num_decodeur;
            $data->num_abonne = $request->num_abonne;
            $data->telephone_client = $request->telephone_client;
            $data->id_user = $userid;
            $decora = Decodeur::create([
                'num_decodeur' => $request->num_decodeur,
                'prix_decodeur' => 0,
                'date_livaison' => date("Y-m-d"),
                'quantite' => 1,
                'id_user' => $userid
            ]);
            $data->id_materiel = $decora->id;
            $client = Client::create([
                'nom_client' => $data->nom_client,
                'prenom_client' => $data->prenom_client,
                'adresse_client' => $data->adresse_client,
                'duree' => $data->duree,
                'id_materiel' => $data->id_materiel,
                'date_abonnement' => $request->date_reabonnement,
                'date_reabonnement' => $data->date_reabonnement,
                'id_user' => $data->id_user,
                'telephone_client' => $data->telephone_client
            ]);

            $CD = ClientDecodeur::create(['id_decodeur' => $decora->id,
                'id_client' => $client->id_client,
                'id_user' => $userid,
                'date_abonnement' => $request->date_reabonnement,
                'date_reabonnement' => $date_reabonnement,
                'id_formule' => $request->newformule,
                'num_abonne' => $data->num_abonne,
            ]);
            $id_client = $client->id_client;
        }

        $statutcaisse = (new VersementController)->resteVersement();

        if ($montant_upgrade > 0) {
            if ($statutcaisse < $montant_upgrade) {
                session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');

                return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');
            }
        }

        $statut = 0;
        if ($request->type == 1) {
            $statut = 1;
        }

        $reabonnement = Reabonnement::create(['id_decodeur' => $data->id_materiel,
            'id_client' => $id_client,
            'id_formule' => 0,
            'id_user' => $userid,
            'type_reabonement' => $request->type,
            'statut_reabo' => $statut,
            'duree' => $data->duree,
            'date_echeance' => $date_reabonnement,
            'date_reabonnement' => $request->date_reabonnement
        ]);

        $upgrade = Upgrade::create([
            'id_oldformule' => $request->oldformule,
            'id_newformule' => $request->newformule,
            'montant_upgrade' => $data->duree * $montant_upgrade,
            'type_upgrade' => $request->type,
            'date_upgrade' => date('Y-m-d'),
            'id_reabonnement' => $request->id_reabonnement,
            'id_abonnement' => 0,
            'statut_upgrade' => $statut,
            'id_user' => $userid,
        ]);

        $data_pdf = new Array_();
        $data_pdf->prix_materiel = 0;
        $data_pdf->nb_materiel = 0;
        $data_pdf->nom_client = $data->nom_client;
        $data_pdf->prenom_client = $data->prenom_client;
        $data_pdf->num_abonne = $data->num_abonne;
        $data_pdf->telephone_client = $data->telephone_client;
        $data_pdf->dureeA = 0;
        $data_pdf->dureeR = 0;
        $data_pdf->dureeU = $data->duree;
//        $data_pdf->dureeU = $data->duree;
        $data_pdf->num_decodeur = $data->num_decodeur;
        $data_pdf->nom_formule = $newformule[0]->nom_formule;
        $data_pdf->prix_formuleU = $montant_upgrade;
        $data_pdf->prix_formuleR = 0;
        $data_pdf->prix_formuleA = 0;
        $data_pdf->total = $data->duree * $montant_upgrade;
        $data_pdf->date_reabonnement = $request->date_reabonnement;
        $data_pdf->date_abonnement = $request->date_reabonnement;

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $request->date_reabonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree * $montant_upgrade;
        $data_message->id_client = $id_client;

        if ($upgrade) {
            $message_con = '';
            $message = $data->nom_client . " Mis à jour de la formule réussi ! Formule: " . $request->formule . ", expire le: " . $data->date_reabonnement . ".";
            $envoi = (new MessageController)->prepareMessage($data_message, 'REABONNEMENT');

        }
        if ($upgrade && $request->type == 1) {
            $storeCaisse = (new CaisseController)->creditCaisse($upgrade->id, 'UPGRADE', $data_pdf->total);

        }
        $balance = (new MessageController)->getSMSBalance();
        $pdf = (new PDFController)->createPDF($data_pdf, 'UPGRADE');
        session()->flash('message', "L'upgrate du client a reussi. Solde SMS: " . $balance);
        return redirect()->route('upgrader')->with('info', "L'upgrate du client a reussi. Solde SMS: " . $balance);
    }
}
