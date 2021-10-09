<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDecodeur;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Reabonnement;
use App\Models\Type_operation;
use App\Models\Upgrade;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\AbstractList;
use App\Models\Abonnement;
use DateInterval;
use DateTime;
use http\Env\Response;
use App\Models\Message;
use App\Models\Materiel;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Expr\Cast;

class ReabonnementController extends Controller
{
    public function reabonneAdd(Request $request)
    {
        $request->validate([
            'nom_client'=>'required',
            'num_decodeur'=>'required',
            'date_abonnement'=>'required',
            'duree'=>'required',
            'formule'=>'required',
            'telephone_client'=>'required',
        ]);
        $userid = Auth::user()->id;
        $decora = Decodeur::create([
            'num_decodeur' => $request->num_decodeur,
            'prix_decodeur' => 0,
            'date_livaison' => date("Y-m-d"),
            'quantite' => 1,
            'id_user' => $userid
        ]);
        $clients = Client::all();
        $formul = Formule::where('nom_formule', $request->formule)->get();
        $deco = Decodeur::where('num_decodeur', $request->num_decodeur)->get();
        $clientdeco = ClientDecodeur::where('id_decodeur', $request->num_decodeur)->get();
        $data = new client;
        $action = "ABONNEMENT";

//        Auth::user()->role==='admin';

        if (empty($deco[0])) {
            session()->flash('message', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre.');

            return redirect()->back()->with('warning', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre!');
        }
        $data->telephone_client = $request->telephone_client;

        foreach ($clients as $cli) {
            if ($cli->telephone_client == $request->telephone_client or $cli->num_abonne == $request->num_abonne) {
                session()->flash('message', ' Le client existe déja!');

                return redirect()->back()->with('warning', 'Le client existe déja!');
            } else {
                $data->telephone_client = $request->telephone_client;
                $data->num_abonne = $request->num_abonne;
            }
        }

        if (!empty($clientdeco[0])) {
            session()->flash('message', ' Ce décodeur est déja utilisé par client!');

            return redirect()->back()->with('warning', 'Ce décodeur est déja utilisé par client!');
        }

//        $data->id_decodeur = $deco[0]->id_decodeur;
//        foreach($formul as $formul1){
        $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();
        if ($statutcaisse < $formul[0]->prix_formule * $request->duree) {
            session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');

            return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');
        }
//        }
        $data->nom_client = $request->nom_client;
        $data->num_abonne = $request->num_abonne;
        $data->prenom_client = $request->prenom_client;
        $data->adresse_client = $request->adresse_client;
        $data->num_decodeur = $request->num_decodeur;
        $data->duree = $request->duree;
        $data->id_materiel = $deco[0]->id_decodeur;
        $data->date_abonnement = $request->date_abonnement;
        $data->date_reabonnement = date_format(date_add(date_create("$request->date_abonnement"), date_interval_create_from_date_string("$request->duree months")), 'Y-m-d');

        $date = new DateTime($data->date_reabonnement);
//        $date->sub(new DateInterval('P1D'));
        $date->sub(new DateInterval("P{$request->duree}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
        $data->date_reabonnement = $date;
        $date_reabonnement = $data->date_reabonnement;
        $data->id_user = $userid;
//        "237679353205",


        $client = Client::create([
            'nom_client' => $data->nom_client,
            'prenom_client' => $data->prenom_client,
            'adresse_client' => $data->adresse_client,
            'duree' => $data->duree,
            'id_materiel' => $deco[0]->id_decodeur,
            'date_abonnement' => $data->date_abonnement,
            'date_reabonnement' => $data->date_reabonnement,
            'id_user' => $data->id_user,
            'telephone_client' => $data->telephone_client
        ]);
        $message_con = "";
//        DD($client->id_client);exit();

        $data_pdf = new Array_();
        $data_pdf->nom_client = $data->nom_client;
        $data_pdf->prenom_client = $data->prenom_client;
        $data_pdf->num_abonne = $data->num_abonne;
        $data_pdf->telephone_client = $data->telephone_client;
        $data_pdf->dureeA = 0;
        $data_pdf->dureeR = $data->duree;
        $data_pdf->dureeU = 0;
        $data_pdf->num_decodeur = $data->num_decodeur;
        $data_pdf->nom_formule = $request->formule;
        $data_pdf->prix_formuleR = $formul[0]->prix_formule;
        $data_pdf->prix_formuleA = 0;
        $data_pdf->prix_formuleU = 0;
        $data_pdf->total = $data->duree * $formul[0]->prix_formule;
        $data_pdf->date_reabonnement = $data->date_reabonnement;
        $data_pdf->date_abonnement = $data->date_abonnement;
        $sendError = '';

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $data->date_abonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree * $formul[0]->prix_formule;
        $data_message->id_client = $client->id_client;
        if (!empty($client)) {
            $CD = ClientDecodeur::create(['id_decodeur' => $deco[0]->id_decodeur,
                'id_client' => $client->id_client,
                'id_user' => $userid,
                'date_abonnement' => $data->date_abonnement,
                'date_reabonnement' => $date_reabonnement,
                'num_abonne' => $date_reabonnement,
                'id_formule' => $id_formule,
            ]);
            $statutreabo = 0;
            if ($request->type == 1) {
                $statutreabo = 1;
            }
            $reabonnement = Reabonnement::create(['id_decodeur' => $deco[0]->id_decodeur,
                'id_client' => $client->id_client,
                'id_formule' => $id_formule,
                'id_user' => $userid,
                'type_reabonement' => $request->type,
                'statut_reabo' => $statutreabo,
                'duree' => $data->duree,
                'date_echeance' => $date_reabonnement,
                'date_reabonnement' => $data->date_abonnement
            ]);
            if ($reabonnement) {

                $storeCaisse = (new CaisseController)->creditCaisse($reabonnement->id_reabonnement, 'REABONNEMENT', $data_pdf->total);

            }
//                $message = ($request->nom_client." Merci de vous etre abonné chez nous! Formule: " .$request->formule . ", expire le: ".$data->date_reabonnement .".");
            $envoi = (new MessageController)->prepareMessage($data_message, 'REABONNEMENT');

        }
//        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance();
        if (!empty($client) && $message_con != "") {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Solde SMS: ' . $balance);
            $pdf = (new PDFController)->createPDF($data_pdf, $action);

            return redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. Solde SMS: ' . $balance);
        }

        if (!empty($client) and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé. Solde SMS: ' . $balance);
            $pdf = (new PDFController)->createPDF($data_pdf, $action);
            return redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.' . "\n Statut: Solde SMS " . $balance);
        } else {
            session()->flash('message', 'Erreur! Le client n\' pas été enrgistré!');

            return redirect()->back()->with('danger', 'Erreur! Le client n\' pas été enrgistré!');
        }
    }

    public function updateR(Request $request, $id_client)
    {
        $request->validate([
            'formule' => 'required',
            'date_reabonnement' => 'required',
            'id_decodeur' => 'required',
        ]);
        $data = Client::find($id_client);
        $formul = Formule::where('nom_formule', $request->formule)->get();
        $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();
        $clientdecodeur = ClientDecodeur::where('id_decodeur',$request->id_decodeur)->get();
        $action = "REABONNEMENT";

        if ($statutcaisse < $formul[0]->prix_formule * $request->duree) {
            session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');

            return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');
        }
        $data->duree = $request->duree;
        $date_reabonnement = date_format(date_add(date_create("$request->date_reabonnement"), date_interval_create_from_date_string("$request->duree months")), 'Y-m-d');

        $date = new DateTime($date_reabonnement);
        $date->sub(new DateInterval("P{$request->duree}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
        $data->date_reabonnement = $date;
        $date_reabonnement = $data->date_reabonnement;

        $date_abonnement = $request->date_reabonnement;
//        dd($data->date_reabonnement, $request->date_reabonnement);
//        DD($request);exit();
        $nom = $request->nom_client;
        $userid = Auth::user()->id;
        $telephone = $request->telephone_client;
        $statutreabo = 0;
        if ($request->type == 1) {
            $statutreabo = 1;
        }
        $reabonnement = Reabonnement::create(['id_decodeur' => $request->id_decodeur,
            'id_client' => $id_client,
            'id_formule' => $id_formule,
            'id_user' => $userid,
            'type_reabonement' => $request->type,
            'statut_reabo' => $statutreabo,
            'duree' => $data->duree,
            'date_echeance' => $date_reabonnement,
            'date_reabonnement' => $request->date_reabonnement
        ]);
        $decodeur = ClientDecodeur::where('id_decodeur', $request->id_decodeur)
            ->where('id_client', $id_client)
            ->update([
                'date_reabonnement' => $date_reabonnement,

            ]);
        $data->num_abonne=$clientdecodeur[0]->num_abonne;
        $num_decodeur = Decodeur::where('id_decodeur', $request->id_decodeur)->get('num_decodeur');
        $data_pdf = new Array_();
        $data_pdf->nom_client = $data->nom_client;
        $data_pdf->prenom_client = $data->prenom_client;
        $data_pdf->num_abonne = $data->num_abonne;
        $data_pdf->telephone_client = $data->telephone_client;
        $data_pdf->dureeA = 0;
        $data_pdf->dureeR = $data->duree;
        $data_pdf->dureeU = 0;
        $data_pdf->num_decodeur = $num_decodeur[0]->num_decodeur;
        $data_pdf->nom_formule = $request->formule;
        $data_pdf->prix_formuleR = $formul[0]->prix_formule;
        $data_pdf->prix_formuleA = 0;
        $data_pdf->prix_formuleU = 0;
        $data_pdf->total = $data->duree * $formul[0]->prix_formule;
        $data_pdf->date_reabonnement = $date_reabonnement;
        $data_pdf->date_abonnement = $date_abonnement;

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $data->date_abonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree * $formul[0]->prix_formule;
        $data_message->id_client = $id_client;
//        DD($request); exit();
        if ($reabonnement) {

            $storeCaisse = (new CaisseController)->creditCaisse($reabonnement->id_reabonnement, 'REABONNEMENT', $data_pdf->total);

            $message_con = '';
//            $storeCaisse = (new CaisseController)->creditCaisse($reabonnement->id, 'REABONNEMENT', $data->duree * $formul[0]->prix_formule);

            $message = $nom . " Votre réabonnement à été effectué avec success! Formule: " . $request->formule . ", expire le: " . $data->date_reabonnement . ".";
            $envoi = (new MessageController)->prepareMessage($data_message, 'REABONNEMENT');

        }
        //        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance();
//        $data->save();
        $pdf = (new PDFController)->createPDF($data_pdf, $action);
        session()->flash('message', 'Le reabonnement a reussi. Solde SMS: ' . $balance);
        return redirect()->route('review.reabonner')->with('info', 'Le reabonnement a reussi. Solde SMS: ' . $balance);
    }

    public function upgradeReabonnement(Request $request, $id_client)
    {
        $request->validate([
            'formule' => 'required',
            'id_reabonnement' => 'required',
            'id_formule' => 'required',
            'id_decodeur' => 'required',
        ]);
        $data = Client::find($id_client);
        $dt = Reabonnement::where('id_client', $request->id_reabonnement)->get();
        $formule = Formule::where('id_formule', $request->id_formule)->get();
        $formul = Formule::where('nom_formule', $request->formule)->get();
        $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();
        $clientdecodeur = ClientDecodeur::where('id_decodeur',$request->id_decodeur)->get();
        $difference = $formul[0]->prix_formule - $formule[0]->prix_formule;
        if ($difference > 0) {
            if ($statutcaisse < $difference) {
                session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');

                return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');
            }
        }
        $userid = Auth::user()->id;
//        $reabonnement = Reabonnement::where('id_reabonnement', $request->id_reabonnement)
//            ->update(['id_decodeur' => $request->id_decodeur,
//                'id_formule' => $id_formule,
//                'id_user' => $userid,
//                'type_reabonement' => $request->type,
//            ]);
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
            'id_reabonnement' => $request->id_reabonnement,
            'id_abonnement' => 0,
            'statut_upgrade' => $statut,
            'id_user' => $userid,
        ]);
        $data->num_abonne = $clientdecodeur[0]->num_abonne;
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

    public function allReabonnement()
    {
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
//            ->select('client_decodeurs.*','client_decodeurs.date_reabonnement as fin',
//                'clients.*', 'reabonnements.date_reabonnement as debut',
//                'formules.*','decodeurs.*','reabonnements.*'
//            )
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get();
        $reabonnement = Reabonnement::all();
        $users = User::all();
        return view("reabonnement.allreabonnement", compact('data', 'users', 'reabonnement'));

    }

    public function review()
    {
        $decodeur = Decodeur::all();
        $clientdecodeur = ClientDecodeur::all();
        $allClients = Client::all();
        $allFormules = Formule::all();

        return view('reabonnement.reabonner', compact('allClients', 'decodeur', 'clientdecodeur', 'allFormules'));
    }

    public function reabonne($id_client)
    {
        $datas = Client::find($id_client);
        //dd($datas);
        $decos = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
            ->where('client_decodeurs.id_client', $id_client)
            ->get();
        return view('reabonnement.new_reabonner', compact('datas', 'decos'));
    }

    public function creditReabonnement()
    {
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->where('reabonnements.type_reabonement', 0)
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get();
        $reabonnement = Reabonnement::all();
        return view("reabonnement.reabonnements_credit", compact('data', 'reabonnement'));
    }

    public function mesReabonnements()
    {
        $userid = Auth::user()->id;
        $date = date("Y-m-d");
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->where('reabonnements.id_user', $userid)
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get();
        $reabonnement = Reabonnement::all();
        return view("reabonnement.mes_reabonnements", compact('data', 'reabonnement'));
    }

    public function mesReabonnementsAjour()
    {
        $userid = Auth::user()->id;
        $date = date("Y-m-d");
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->where('reabonnements.created_at', 'LIKE', "%{$date}%")
            ->where('clients.id_user', $userid)
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get();
        return view("reabonnement.mes_reabonnementsjour", compact('data'));
    }

    public function deleteReabonne(Request $request)
    {
        $id = $request->id;
        $delete = Reabonnement::where('id_reabonnement', $id)->delete();
        $storeCaisse = (new CaisseController)->removerFromCaisse($id, 'REABONNEMENT');
//        $storeCaisse = (new CaisseController)->creditCaisse($reabonnement->id,'REABONNEMENT',$data->duree *  $formul[0]->prix_formule);

        return Response()->json($delete);
    }

    public function recoverReabonne(Request $request)
    {
        $id = $request->id;
        $userid = Auth::user()->id;
        $reabo = Reabonnement::where('id_reabonnement',$id)->get();
        $montant = 0;
        if ($reabo){
            $formul = Formule::where('id_formule',$reabo[0]->id_reabonnement)->get();
            if ($formul){
                $montant = $formul[0]->prix_formule*$reabo[0]->duree;
            }
        }
        $save = Type_operation::create([
        'id_reabonnement'=>$id,
        'id_abonnement'=>0,
        'id_upgrade'=>0,
        'date_ajout'=>date('Y-m-d'),
        'id_user'=>$userid,
        'montant'=>$montant,
        'type'=>1,
        'operation'=>'REABONNEMENT',
    ]);
        if ($save){
            $recover = Reabonnement::where('id_reabonnement', $id)->update(['type_reabonement' => 1]);

        }

        return Response()->json($recover);
    }

    public function up_client($id_client, $id_reabonnement)
    {

        $reabonnement = Reabonnement::where('id_reabonnement', $id_reabonnement)->get();
        $decodeur = Decodeur::where('id_decodeur', $reabonnement[0]->id_decodeur)->get();
        $decos = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
            ->where('client_decodeurs.id_client', $reabonnement[0]->id_decodeur)
            ->get();
        return view('upgrade.upgrade', [
            'datas' => Client::find($id_client),
            'reabonnement' => Reabonnement::where('id_reabonnement', $id_reabonnement)->get(),
            'formule' => Formule::where('id_formule', $reabonnement[0]->id_formule)->get(),
            'decodeur' => Decodeur::where('id_decodeur', $reabonnement[0]->id_decodeur)->get(),
            'decos' => $decos
        ]);
    }

}
