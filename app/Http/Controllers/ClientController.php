<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Stock;
use App\Models\Upgrade;
use App\Models\Vente_materiel;
use DateInterval;
use DateTime;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Formule;
use App\Models\Message;
use App\Models\ClientDecodeur;
use App\Models\Reabonnement;
use App\Models\User;
use App\Models\Materiel;
use App\Models\Decodeur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\AbstractList;
use PhpParser\Node\Expr\Cast;

//use PhpParser\Node\Expr\Cast\Array_;
use Vonage\Client\Exception\Exception;
use function PHPUnit\Framework\exactly;
use phpDocumentor\Reflection\Types\Array_;

//use Exception;

class ClientController extends Controller
{

    public function view()
    {
        $userid = Auth::user()->id;
        $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->where('client_decodeurs.date_reabonnement', '>=', date('Y-m-d'))
            ->get();
        $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
            ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
            ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
            )
            ->where('abonnements.date_echeance', '>=', date('Y-m-d'))
            ->OrderBy('abonnements.id_abonnement', 'DESC')
            ->get();
        $clientdeco = ClientDecodeur::all();

        $id_decodeur = [];
        foreach ($clientdeco as $key => $value) {
            $id_decodeur[$key] = $value->id_decodeur;
        }
//        dd($id_decodeur);

        $decodeur = Decodeur::whereNotIn('decodeurs.id_decodeur', $id_decodeur)
            ->get();
        $users = User::all();
        $reabonnement = Abonnement::all();
        $stock = Stock::where('statut', 0)->get();
        return view("abonnement.abonner", compact('decodeur', 'stock', 'data', 'users', 'reabonnement', 'clientdecodeur'));
    }


    public function allview()
    {

        $allClients = Client::all();
        $allFormules = Formule::all();
        $decodeurs = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
            ->get();

        $messages = (new MessageController)->getStandart();
        $clientdecodeur = ClientDecodeur::all();

        $id_decodeur = [];
        foreach ($clientdecodeur as $key => $value) {
            $id_decodeur[$key] = $value->id_decodeur;
        }
//        dd($id_decodeur);

        $decodeur = Decodeur::whereNotIn('decodeurs.id_decodeur', $id_decodeur)
            ->get();
//        dd($decodeur);
        $stock = Stock::where('statut', 0)->get();
        return view('client.clients', compact('allClients', 'stock', 'decodeur', 'clientdecodeur', 'allFormules', 'decodeurs', 'messages'));
    }


    public function add()
    {
        return view('abonner_add');
    }


    public function updateM(Request $request)
    {
        $request->validate([
            'nom_client' => 'required',
            'telephone_client' => 'required',
            'id_client' => 'required',
            'num_decodeur' => 'required',
            'num_abonne' => 'required',
            'prix_decodeur' => 'required',
        ]);
        $client = Client::where('id_client', $request->id_client)
            ->update([
                'nom_client' => $request->nom_client,
                'prenom_client' => $request->prenom_client,
                'telephone_client' => $request->telephone_client,
                'adresse_client' => $request->adresse_client
            ]);
        if (count($request->num_decodeur) === count($request->id_decodeur)) {
            for ($i = 0; $i < count($request->num_decodeur); $i++) {
                $decodeur[$i] = Decodeur::where('id_decodeur', $request->id_decodeur[$i])
                    ->update([
                        'num_decodeur' => $request->num_decodeur[$i],
                    ]);
                $clientdeco = ClientDecodeur::where('id_client', $request->id_client)
                    ->where('id', $request->id[$i])
                    ->update(['num_abonne' => $request->num_abonne[$i]]);;
            }
        } else {
            return redirect()->back()->with('danger', "Echec lors de l'enregistrement! données du formulaire mal saisie.");
        }
//        dd($client);
        if ($client && $decodeur) {
            return redirect()->route('clients')->with('success', 'Effectué avec succes');
        } else {
            return redirect()->back()->with('danger', "Erreur lors de l'enregistrement!");

        }


    }


    public function store(Request $request)
    {
        $request->validate([
            'nom_client' => 'required',
            'id_decodeur' => 'required',
            'date_abonnement' => 'required',
            'telephone_client' => 'required',
            'duree' => 'required',
            'formule' => 'required',
        ]);
        $clients = Client::all();
        $formul = Formule::where('nom_formule', $request->formule)->get();
        $getstock = Stock::where('id_stock', $request->id_decodeur)->get();
        $deco = Decodeur::where('num_decodeur', $getstock[0]->code_stock)->get();
//        $clientdeco = ClientDecodeur::where('id_decodeur', $deco[0]->id_decodeur)->get();
        $data = new client;
        $action = "ABONNEMENT";


//        Auth::user()->role==='admin';
        $userid = Auth::user()->id;


//        if (empty($deco[0])) {
//            session()->flash('message', ' Le décodeur n\' existe pas! Veillez l\'enregistrer ou entrez un autre.');
//
//            return redirect()->back()->with('warning', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre!');
//        }
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

        if (!empty($deco[0])) {
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

        $decora = Decodeur::create([
            'num_decodeur' => $getstock[0]->code_stock,
            'prix_decodeur' => $request->prix_decodeur,
            'date_livaison' => date("Y-m-d"),
            'quantite' => 1,
            'id_user' => $userid
        ]);
        $change_Statut = Stock::where('id_stock', $request->id_decodeur)
            ->update([
                'statut' => 1
            ]);
        $deco = Decodeur::where('num_decodeur', $getstock[0]->code_stock)->get();

        $data->prix_materiel = $request->prix_decodeur;
        $data->nb_materiel = 1;
        $data->nom_client = $request->nom_client;
        $data->num_abonne = $request->num_abonne;
        $data->prenom_client = $request->prenom_client;
        $data->adresse_client = $request->adresse_client;
        $data->num_decodeur = $getstock[0]->code_stock;
        $data->duree = $request->duree;
        $data->id_materiel = $getstock[0]->id_stock;
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
        $data_pdf->prix_materiel = $request->prix_decodeur;
        $data_pdf->nb_materiel = 1;
        $data_pdf->nom_client = $data->nom_client;
        $data_pdf->prenom_client = $data->prenom_client;
        $data_pdf->num_abonne = $data->num_abonne;
        $data_pdf->telephone_client = $data->telephone_client;
        $data_pdf->dureeA = $data->duree;
        $data_pdf->dureeR = 0;
        $data_pdf->dureeU = 0;
        $data_pdf->num_decodeur = $data->num_decodeur;
        $data_pdf->nom_formule = $request->formule;
        $data_pdf->prix_formuleA = $formul[0]->prix_formule;
        $data_pdf->prix_formuleR = 0;
        $data_pdf->prix_formuleU = 0;
        $data_pdf->total = $data->duree * $formul[0]->prix_formule + $request->prix_decodeur;
        $data_pdf->date_reabonnement = $data->date_reabonnement;
        $data_pdf->date_abonnement = $data->date_abonnement;
        $sendError = '';

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $data->date_abonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree * $formul[0]->prix_formule + $request->prix_decodeur;
        $data_message->id_client = $client->id_client;
//        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance();


        if (!empty($client)) {

            $CD = ClientDecodeur::create(['id_decodeur' => $deco[0]->id_decodeur,
                'id_client' => $client->id_client,
                'id_user' => $userid,
                'date_abonnement' => $data->date_abonnement,
                'date_reabonnement' => $date_reabonnement,
                'id_formule' => $id_formule,
                'num_abonne' => $data->num_abonne,
            ]);

            $abonnement = Abonnement::create([
                'id_decodeur' => $deco[0]->id_decodeur,
                'id_client' => $client->id_client,
                'id_formule' => $id_formule,
                'id_user' => $userid,
                'type_abonnement' => 1,
                'statut_abo' => 1,
                'duree' => $data->duree,
                'date_reabonnement' => $data->date_abonnement,
                'date_echeance' => $date_reabonnement
            ]);

            if ($abonnement) {
                $storeCaisse = (new CaisseController)->creditCaisse($abonnement->id, 'ABONNEMENT', $data_pdf->total);
                if (isset($request->sendsms) && $request->sendsms == 1) {
                    $envoi = (new MessageController)->prepareMessage($data_message, 'ABONNEMENT');
                }
                if (isset($request->printpdf) && $request->printpdf == 1) {
                    (new PDFController)->createPDF($data_pdf, $action);
                }
            }

        }

        if (!empty($client) && $message_con != "") {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Solde message:' . $balance . $message_con);

            return redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. Solde message:' . $balance);
        }

        if (!empty($client) and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé. solde message :' . $balance);
//            $pdf = (new PDFController)->createPDF($data_pdf, $action);
            return redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.' . "\n Statut: solde message" . $balance);
        } else {
            session()->flash('message', 'Erreur! Le client n\' pas été enrgistré!');

            return redirect()->back()->with('danger', 'Erreur! Le client n\' pas été enrgistré! Solde message:' . $balance);
        }
    }

    public function show($id)
    {
        $client = Client::where('id_client', $id)
            ->get();
        $user = User::where('id', $client[0]->id_user)->get();
        $decodeurs = ClientDecodeur::join('decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->where('client_decodeurs.id_client', $id)->get()
        ;
        $reabonnements = Reabonnement::join('users', 'users.id', 'reabonnements.id_user')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('formules', 'formules.id_formule', 'reabonnements.id_formule')
            ->where('reabonnements.id_client', $id)
            ->OrderBy('id_reabonnement', 'DESC')
            ->get()
        ;
        $abonnements = Abonnement::join('users', 'users.id', 'abonnements.id_user')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('formules', 'formules.id_formule', 'abonnements.id_formule')
            ->where('abonnements.id_client', $id)
            ->OrderBy('id_abonnement', 'DESC')
            ->get()
        ;
        $id_reabonnement =Reabonnement::where('id_Client',$id)->get('id_reabonnement');
        $id_abonnement =Abonnement::where('id_client',$id)->get('id_abonnement');
//        $id_reabonnement = DB::table("reabonnements")->get('id_reabonnement');
        $TIDR = [];
        $TIDA = [];
        foreach ($id_reabonnement as $key => $item)
        {
            $TIDR[$key] = $item->id_reabonnement;
        }
        foreach ($id_abonnement as $key => $item)
        {
            $TIDA[$key] = $item->id_abonnement;
        }
        $upgrades = Upgrade::join('users','users.id','upgrades.id_user')
            ->whereIn('id_reabonnement',$TIDR)
            ->orWhereIn('id_abonnement',$TIDA)->get();
        ;
        $formules = Formule::all();
        $reabonnement = Reabonnement::where('id_client', $id)->get();
        $achats = Vente_materiel::join('users','users.id','vente_materiels.id_user')
            ->join('stocks','stocks.id_stock','vente_materiels.id_stock')
            ->where('id_client',$id)
            ->get();
        ;
        $allFormules = Formule::all();
        $messages = (new MessageController)->getStandart();
        $stock = Stock::where('statut', 0)->get();
        return view('client.detailsclient', compact('upgrades','stock','messages','formules','abonnements','formules','id','client', 'decodeurs', 'reabonnements', 'user', 'reabonnement','achats'));
    }


    public function deleteClient(Request $request)
    {
        $id = $request->id_client;
        $delete = Client::where('id_client', $id)->delete();
        return Response()->json($delete);
    }


    public function edit_client($id_client)
    {
        $datas = Client::find($id_client);
        $decodeurs = ClientDecodeur::join('decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->where('id_client', $id_client)->get();
        //dd($datas);
        return view('client.modif_client', compact('datas', 'decodeurs'));
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('info', 'Le client a été effacé avec succès.');
    }

    public function nouveauClient()
    {

        $userid = Auth::user()->id;
        $data = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('formules', 'client_decodeurs.id_formule', 'formules.id_formule')
            ->join('clients', 'clients.id_client', 'client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement', '>=', date('Y-m-d'))
            ->get();
        $messages = (new MessageController)->getStandart();
        return view("client.clientNouveau", compact('data', 'messages'));
    }

    public function bientotATerme()
    {
        $date_reabonnement = date_format(date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string("3 days")), 'Y-m-d');

        $data = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('formules', 'client_decodeurs.id_formule', 'formules.id_formule')
            ->join('clients', 'clients.id_client', 'client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement', '<=', $date_reabonnement)
            ->where('client_decodeurs.date_reabonnement', '>=', date('Y-m-d'))
//         ->where('client_decodeurs.id_user',$userid)
            ->get();
        $messages = (new MessageController)->getStandart();
        return view("client.bientoTerme", compact('data', 'messages'));
    }

    public function clientPerdu()
    {
//     $envoi = (new MessageController)->sendMessage($message,$request->telephone_client );
        $userid = Auth::user()->id;
        $date = date("Y-m-d");
        $data = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('formules', 'client_decodeurs.id_formule', 'formules.id_formule')
            ->join('clients', 'clients.id_client', 'client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement', '<=', date('Y-m-d'))
//         ->where('client_decodeurs.id_user',$userid)
            ->get();
        $messages = (new MessageController)->getStandart();
        return view("client.clientPerdu", compact('data', 'messages'));
    }

    public function relancerClient($numero)
    {
        $message = "Votre abonnement canal+ a expiré. Nous vous prions de vous reabonner.";
        $envoi = (new MessageController)->sendMessage($message, $numero);
        if ($envoi == 0) {
            session()->flash('message', 'Client relancé avec succès!');

            return redirect()->back()->with('success', 'Client relancé avec succès!');
        } else {
            session()->flash('message', 'Echec de l\'envoi du message!');

            return redirect()->back()->with('danger', 'Echec de l\'envoi du message!');
        }

    }

    public function newDecodeur(Request $request)
    {
        $request->validate([
            'operation' => 'required',
            'num_abonne' => 'required',
            'date_abonnement' => 'required',
            'formule' => 'required',
            'id_client' => 'required',
            'type' => 'required',
        ]);

        $nb_materiel = 0;
        if ($request->operation == 1) {
            $request->validate([
                'id_decodeur' => 'required',
            ]);
            $getstock = Stock::where('id_stock', $request->id_decodeur)->get();
            $deco = Decodeur::where('num_decodeur', $getstock[0]->code_stock)->get();
            $num_decodeur = $getstock[0]->code_stock;
            $nb_materiel = 1;
        }
        if ($request->operation == 0) {
            $request->validate([
                'num_decodeur' => 'required',
            ]);
            $num_decodeur = $request->num_decodeur;
        }
        $userid = Auth::user()->id;
        $clients = Client::where('id_client', $request->id_client)->get();
        $formul = Formule::where('nom_formule', $request->formule)->get();
        $deco = Decodeur::where('num_decodeur', $num_decodeur)->get();
        if (empty($deco[0])) {
            if ($request->operation == 0) {
                $decora = Decodeur::create([
                    'num_decodeur' => $num_decodeur,
                    'prix_decodeur' => 0,
                    'date_livaison' => date("Y-m-d"),
                    'quantite' => 1,
                    'id_user' => $userid
                ]);

            } else {

                $decora = Decodeur::create([
                    'num_decodeur' => $getstock[0]->code_stock,
                    'prix_decodeur' => $request->prix_decodeur,
                    'date_livaison' => date("Y-m-d"),
                    'quantite' => 1,
                    'id_user' => $userid
                ]);
                $change_Statut = Stock::where('id_stock', $request->id_decodeur)
                    ->update([
                        'statut' => 1
                    ]);
            }

        }
        $deco = Decodeur::where('num_decodeur', $num_decodeur)->get();
        if (!empty($deco[0])) {

            $clientdeco = ClientDecodeur::where('id_decodeur', $deco[0]->id_decodeur)
                ->Orwhere('num_abonne', $request->num_abonne)
                ->get();
        } else {
            return redirect()->back()->with('danger', "Une erreur s'est produit! Veillez recommencer.");
        }
        $data = new client;
        $action = "ABONNEMENT";
//        $id_decodeur = 0;

        $data->telephone_client = $clients[0]->telephone_client;
        $id_decodeur = $deco[0]->id_decodeur;
        $prix_decodeur = $deco[0]->prix_decodeur;
        if (!empty($clientdeco[0])) {
            session()->flash('message', ' Ce décodeur ou numéro d\'abonné est déja utilisé par client!');

            return redirect()->back()->with('warning', 'Ce décodeur est déja utilisé par client!');
        }

        $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();
        if ($statutcaisse < $formul[0]->prix_formule * $request->duree) {
            session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');

            return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' . $statutcaisse . ' FCFA en caisse.');
        }
//        }
        $data->prix_materiel = $prix_decodeur;
        $data->nb_materiel = $nb_materiel;
        $data->nom_client = $clients[0]->nom_client;
        $data->num_abonne = $request->num_abonne;
        $data->prenom_client = $clients[0]->prenom_client;
        $data->adresse_client = $clients[0]->adresse_client;
        $data->num_decodeur = $num_decodeur;
        $data->duree = $request->duree;
        $data->id_materiel = $id_decodeur;
        $data->date_abonnement = $request->date_abonnement;
        $data->date_reabonnement = date_format(date_add(date_create("$request->date_abonnement"), date_interval_create_from_date_string("$request->duree months")), 'Y-m-d');
        $date = new DateTime($data->date_reabonnement);
//        $date->sub(new DateInterval('P1D'));
        $date->sub(new DateInterval("P{$request->duree}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
        $data->date_reabonnement = $date;
        $date_reabonnement = $data->date_reabonnement;
        $data->id_user = $userid;

        $message_con = "";

        $data_pdf = new Array_();
        $data_pdf->prix_materiel = $prix_decodeur;
        $data_pdf->nb_materiel = $nb_materiel;
        $data_pdf->nom_client = $data->nom_client;
        $data_pdf->prenom_client = $data->prenom_client;
        $data_pdf->num_abonne = $data->num_abonne;
        $data_pdf->telephone_client = $data->telephone_client;

        $data_pdf->num_decodeur = $data->num_decodeur;
        $data_pdf->nom_formule = $request->formule;

        $data_pdf->total = $data->duree * $formul[0]->prix_formule + $prix_decodeur;
        $data_pdf->date_reabonnement = $data->date_reabonnement;
        $data_pdf->date_abonnement = $data->date_abonnement;
        $sendError = '';

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $data->date_abonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree * $formul[0]->prix_formule + $prix_decodeur;
        $data_message->id_client = $request->id_client;

        if (!empty($request->id_client)) {
            $CD = ClientDecodeur::create(['id_decodeur' => $id_decodeur,
                'id_client' => $request->id_client,
                'id_user' => $userid,
                'date_abonnement' => $data->date_abonnement,
                'date_reabonnement' => $date_reabonnement,
                'id_formule' => $id_formule,
                'num_abonne' => $data->num_abonne,
            ]);
            $statut = 0;
            if ($request->type == 1) {
                $statut = 1;
            }
            if ($request->operation == 0) {
                $reabonnement = Reabonnement::create(['id_decodeur' => $id_decodeur,
                    'id_client' => $request->id_client,
                    'id_formule' => $id_formule,
                    'id_user' => $userid,
                    'type_reabonement' => $request->type,
                    'duree' => $data->duree,
                    'date_reabonnement' => $data->date_abonnement,
                    'date_echeance' => $date_reabonnement,
                    'statut_reabo' => $statut,
                ]);
                $data_pdf->dureeA = 0;
                $data_pdf->dureeR = $data->duree;
                $data_pdf->dureeU = 0;
                $data_pdf->prix_formuleA = 0;
                $data_pdf->prix_formuleR = $formul[0]->prix_formule;
                $data_pdf->prix_formuleU = 0;
                if ($reabonnement && $request->type == 1) {
                    $storeCaisse = (new CaisseController)->creditCaisse($reabonnement->id, 'REABONNEMENT', $data_pdf->total);

                    if (isset($request->sendsms) && $request->sendsms == 1) {
                        $envoi = (new MessageController)->prepareMessage($data_message, 'REABONNEMENT');

                    }
                }
            }

            if ($request->operation == 1) {
                $abonnement = Abonnement::create([
                    'id_decodeur' => $deco[0]->id_decodeur,
                    'id_client' => $request->id_client,
                    'id_formule' => $id_formule,
                    'id_user' => $userid,
                    'type_abonnement' => $request->type,
                    'statut_abo' => $statut,
                    'duree' => $data->duree,
                    'date_reabonnement' => $data->date_abonnement,
                    'date_echeance' => $date_reabonnement,
                ]);
                $data_pdf->dureeA = $data->duree;
                $data_pdf->dureeR = 0;
                $data_pdf->dureeU = 0;
                $data_pdf->prix_formuleA = $formul[0]->prix_formule;
                $data_pdf->prix_formuleR = 0;
                $data_pdf->prix_formuleU = 0;
                if ($abonnement && $request->type == 1) {
                    $storeCaisse = (new CaisseController)->creditCaisse($abonnement->id, 'ABONNEMENT', $data_pdf->total);
                }
                if (isset($request->sendsms) && $request->sendsms == 1) {
                    $envoi = (new MessageController)->prepareMessage($data_message, 'ABONNEMENT');

                }
            }


        }
//        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance();
        if (!empty($reabonnement) || !empty($abonnement) && !empty($CD)) {
            session()->flash('message', 'Enregistré avec succès. Solde SMS: ' . $balance);


            if (isset($request->printpdf) && $request->printpdf == 1) {
                (new PDFController)->createPDF($data_pdf, $action);
            }

            return redirect()->back()->with('info', 'Enregistré avec succès. Solde SMS: ' . $balance);
        }

        if (!empty($reabonnement) and empty($message_con)) {
            session()->flash('message', 'Enregistré avec succès. Mais le message n\'a pas été envoyé. solde SMS: ' . $balance);
            $pdf = (new PDFController)->createPDF($data_pdf, $action);
            return redirect()->back()->with('warning', 'Enregistré avec succès. Mais le message n\'a pas été envoyé.' . "\n Statut: solde SMS: " . $balance);
        } else {
            session()->flash('message', 'Erreur lors de l\'enregistrement!');

            return redirect()->back()->with('danger', 'Erreur lors de l\'enregistrement!');
        }

    }

    public function addNewClient(Request $request)
    {
        $request->validate([
            'nom_client' => 'required',
            'telephone_client' => 'required',
            'adresse_client' => 'required',
        ]);

        $userid = Auth::user()->id;
        $clients = Client::where('telephone_client',$request->telephone_client)->get();
            if (count($clients)>0) {
                session()->flash('message', ' Le client existe déja!');

                return redirect()->back()->with('warning', 'Le client existe déja!');
            }
            if (isset($request->num_decodeur) && isset($request->num_abonne))
            {
                $checkdecodeur = Decodeur::join('client_decodeurs','client_decodeurs.id_decodeur','decodeurs.id_decodeur')
                    ->whereIn('num_decodeur',$request->num_decodeur)
                    ->OrWhereIn('num_abonne',$request->num_abonne)
                    ->get()
                ;
            }

            if (isset($checkdecodeur) && count($checkdecodeur)>0)
            {
                return redirect()->back()->with('danger', 'Le numéro de décodeur ou le numéro d\'abonné est déja utilisé.');
            }
        $client = Client::create([
            'nom_client' => $request->nom_client,
            'prenom_client' => $request->prenom_client,
            'adresse_client' => $request->adresse_client,
            'duree' => 0,
            'id_materiel' => 0,
            'date_abonnement' => date('Y-m-d'),
            'date_reabonnement' => date('Y-m-d'),
            'id_user' => $userid,
            'telephone_client' => $request->telephone_client
        ]);
        $client = Client::where('telephone_client',$request->telephone_client)->get();
        if (!empty($client)) {

            if (isset($request->num_decodeur) && isset($request->num_abonne))
            {
                for($i = 0; $i<count($request->num_decodeur); $i++)
                {
                    $decora[$i] = Decodeur::create([
                        'num_decodeur' => $request->num_decodeur[$i],
                        'prix_decodeur' => 0,
                        'date_livaison' => date("Y-m-d"),
                        'quantite' => 1,
                        'id_user' => $userid
                    ]);
                    $deco= Decodeur::where('num_decodeur',$request->num_decodeur[$i])->get();

                    $CD[$i] = ClientDecodeur::create(['id_decodeur' => $deco[0]->id_decodeur,
                        'id_client' => $client[0]->id_client,
                        'id_user' => $userid,
                        'date_abonnement' => date('Y-m-d'),
                        'date_reabonnement' => date('Y-m-d'),
                        'id_formule' => 0,
                        'num_abonne' => $request->num_abonne[$i],
                    ]);
                }

            }

           return $this->show($client[0]->id_client);
//            return redirect()->back()->with('success', 'Le client a été avec succès.');

        } else {
            session()->flash('message', 'Erreur lors de l\'enregistrement!');

            return redirect()->back()->with('danger', 'Erreur lors de l\'enregistrement!');
        }
    }

}
