<?php

namespace App\Http\Controllers;

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
use phpDocumentor\Reflection\Types\AbstractList;
use PhpParser\Node\Expr\Cast;
//use PhpParser\Node\Expr\Cast\Array_;
use Vonage\Client\Exception\Exception;
use function PHPUnit\Framework\exactly;
use phpDocumentor\Reflection\Types\Array_;
//use Exception;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $allClients = Client::all();
        $allFormules = Formule::all();
        $decodeur = Decodeur::all();
        $clientdecodeur = ClientDecodeur::all();
//        dd($decodeur, $clientdecodeur);
        return view('abonner',compact('allClients','allFormules','decodeur','clientdecodeur'));
    }

    public function review()
    {
        $allClients = Client::all();
        $allFormules = Formule::all();
        return view('reabonner',compact('allClients','allFormules'));
    }

    public function allview()
    {
        $allClients = Client::all();
        $allFormules = Formule::all();
        $decodeurs = Decodeur::join('client_decodeurs','client_decodeurs.id_decodeur','decodeurs.id_decodeur')
            ->get();
        $messages = (new MessageController)->getStandart();
        return view('clients',compact('allClients','allFormules', 'decodeurs','messages'));
    }

    public function viewModif()
    {
        $userid= Auth::user()->id;
        $clientdecodeur = Decodeur::join('client_decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
            ->where('client_decodeurs.date_reabonnement','>=',date('Y-m-d'))
            ->get();
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs','decodeurs.id_decodeur','reabonnements.id_decodeur')
            ->join('client_decodeurs','reabonnements.id_decodeur','client_decodeurs.id_decodeur')
            ->where('client_decodeurs.date_reabonnement','>=',date('Y-m-d'))
//            ->where('clients.id_user', $userid)
            ->OrderBy('reabonnements.id_reabonnement','DESC')
            ->get();
        $reabonnement = Reabonnement::all();
        return view("upgrader", compact('data','reabonnement','clientdecodeur'));
    }

    public function add()
    {
        return view('abonner_add');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateM(Request $request)
    {
        $client = Client::where('id_client',$request->id_client)
            ->update([
                'nom_client'=>$request->nom_client,
                'prenom_client'=>$request->prenom_client,
                'telephone_client'=>$request->telephone_client,
                'adresse_client'=>$request->adresse_client
                ]);
        if (count($request->num_decodeur) === count($request->id_decodeur)){
           for ( $i = 0; $i < count($request->num_decodeur); $i++ ){
               $decodeur[$i] = Decodeur::where('id_decodeur',$request->id_decodeur[$i])
                   ->update([
                       'num_decodeur'=>$request->num_decodeur[$i],
                   ]);
           }
        }else{
            return redirect()->back()->with('danger',"Echec lors de l'enregistrement! données du formulaire mal saisie.");
        }
//        dd($client);
        if ($client && $decodeur){
            return redirect()->route('clients')->with('success','Effectué avec succes');
        }else{
            return redirect()->back()->with('danger',"Erreur lors de l'enregistrement!");

        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clients = Client::all();
        $formul = Formule::where('nom_formule',$request->formule)->get();
        $deco = Decodeur::where('num_decodeur',$request->num_decodeur)->get();
        $clientdeco = ClientDecodeur::where('id_decodeur',$deco[0]->id_decodeur)->get();
        $data = new client;
        $action = "ABONNEMENT";


//        Auth::user()->role==='admin';
        $userid= Auth::user()->id;


        if (empty($deco[0])){
            session()->flash('message', ' Le décodeur n\' existepas! Veillez l\'enregistrer ou entrez un autre.');

            return redirect()->back()->with('warning', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre!');
        }
        $data->telephone_client = $request->telephone_client;

        foreach($clients as $cli){
            if($cli->telephone_client == $request->telephone_client or $cli->num_abonne == $request->num_abonne){
                session()->flash('message', ' Le client existe déja!');

                return redirect()->back()->with('warning', 'Le client existe déja!');
            }
            else{
               $data->telephone_client = $request->telephone_client;
               $data->num_abonne = $request->num_abonne;
            }
        }

                if(!empty($clientdeco[0])){
                session()->flash('message', ' Ce décodeur est déja utilisé par client!');

                return redirect()->back()->with('warning', 'Ce décodeur est déja utilisé par client!');
            }

//        $data->id_decodeur = $deco[0]->id_decodeur;
//        foreach($formul as $formul1){
            $id_formule = $formul[0]->id_formule;
             $statutcaisse = (new VersementController)->resteVersement();
             if ($statutcaisse < $formul[0]->prix_formule * $request->duree){
                 session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');

                 return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');
             }
//        }
        $data->nom_client = $request->nom_client;
        $data->num_abonne = $request->num_abonne;
        $data->prenom_client = $request->prenom_client;
        $data->adresse_client = $request->adresse_client;
        $data->num_decodeur =$request->num_decodeur;
        $data->duree = $request->duree;
        $data->id_materiel = $deco[0]->id_decodeur;
        $data->date_abonnement = $request->date_abonnement;
        $data->date_reabonnement = date_format(date_add(date_create("$request->date_abonnement"),date_interval_create_from_date_string("$request->duree months")),'Y-m-d');
        $date = new DateTime($data->date_reabonnement);
//        $date->sub(new DateInterval('P1D'));
        $date->sub(new DateInterval("P{$request->duree}D"));
        $date =  date("Y-m-d", strtotime($date->format('Y-m-d')));
        $data->date_reabonnement = $date;
        $date_reabonnement=$data->date_reabonnement;
        $data->id_user = $userid;
//        "237679353205",


        $client = Client::create([
            'nom_client'=>$data->nom_client,
            'num_abonne'=>$data->num_abonne,
            'prenom_client' =>$data->prenom_client,
            'adresse_client'=>$data->adresse_client,
            'duree' => $data->duree,
            'id_materiel' => $deco[0]->id_decodeur,
            'date_abonnement'=> $data->date_abonnement,
            'date_reabonnement'=>$data->date_reabonnement,
            'id_user'=>$data->id_user,
            'telephone_client'=>$data->telephone_client
        ]);
        $message_con ="";
//        DD($client->id_client);exit();

        $data_pdf = new Array_();
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
        $data_pdf->total = $data->duree *  $formul[0]->prix_formule;
        $data_pdf->date_reabonnement = $data->date_reabonnement;
        $data_pdf->date_abonnement = $data->date_abonnement;
        $sendError = '';

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $data->date_abonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree *  $formul[0]->prix_formule;
        $data_message->id_client = $client->id_client;
//        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance() ;


        if (!empty($client)){

            $CD = ClientDecodeur::create(['id_decodeur'=>$deco[0]->id_decodeur,
                'id_client'=>$client->id_client,
                'id_user'=>$userid,
                'date_abonnement'=> $data->date_abonnement,
                'date_reabonnement'=>$date_reabonnement,
                'id_formule'=>$id_formule,
            ]);

            $reabonnement = Reabonnement::create(['id_decodeur'=>$deco[0]->id_decodeur,
                'id_client'=>$client->id_client,
                'id_formule'=>$id_formule,
                'id_user'=>$userid,
                'type_reabonement'=>1,
                'duree'=>$data->duree,
                'date_reabonnement'=>$date_reabonnement
            ]);

            $envoi = (new MessageController)->prepareMessage($data_message,'ABONNEMENT');
//                $envoi = (new MessageController)->sendMessage($message,$request->telephone_client );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $sendError =$envoi;
//                }

        }

        if (!empty($client) && $message_con!="") {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Solde message:'.$balance.$message_con);
            $pdf = (new PDFController)->createPDF($data_pdf,$action);

            return  redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. Solde message:'.$balance);
        }

        if (!empty($client)  and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé. solde message :'.$balance  );
            $pdf = (new PDFController)->createPDF($data_pdf,$action);
            return  redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.'."\n Statut: solde message".$balance);
        } else {
            session()->flash('message', 'Erreur! Le client n\' pas été enrgistré!');

            return redirect()->back()->with('danger', 'Erreur! Le client n\' pas été enrgistré! Solde message:'.$balance);
        }
    }

    public function reabonneAdd(Request $request)
    {
        $userid= Auth::user()->id;
        $decora = Decodeur::create([
            'num_decodeur'=>$request->num_decodeur,
            'prix_decodeur'=>0,
            'date_livaison'=>date("Y-m-d"),
            'quantite'=> 1,
            'id_user'=>$userid
        ]);
        $clients = Client::all();
        $formul = Formule::where('nom_formule',$request->formule)->get();
        $deco = Decodeur::where('num_decodeur',$request->num_decodeur)->get();
        $clientdeco = ClientDecodeur::where('id_decodeur',$request->num_decodeur)->get();
        $data = new client;
        $action = "ABONNEMENT";


//        Auth::user()->role==='admin';



        if (empty($deco[0])){
            session()->flash('message', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre.');

            return redirect()->back()->with('warning', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre!');
        }
        $data->telephone_client = $request->telephone_client;

        foreach($clients as $cli){
            if($cli->telephone_client == $request->telephone_client or $cli->num_abonne == $request->num_abonne){
                session()->flash('message', ' Le client existe déja!');

                return redirect()->back()->with('warning', 'Le client existe déja!');
            }
            else{
                $data->telephone_client = $request->telephone_client;
                $data->num_abonne = $request->num_abonne;
            }
        }

        if(!empty($clientdeco[0])){
            session()->flash('message', ' Ce décodeur est déja utilisé par client!');

            return redirect()->back()->with('warning', 'Ce décodeur est déja utilisé par client!');
        }

//        $data->id_decodeur = $deco[0]->id_decodeur;
//        foreach($formul as $formul1){
        $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();
        if ($statutcaisse < $formul[0]->prix_formule * $request->duree){
            session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');

            return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');
        }
//        }
        $data->nom_client = $request->nom_client;
        $data->num_abonne = $request->num_abonne;
        $data->prenom_client = $request->prenom_client;
        $data->adresse_client = $request->adresse_client;
        $data->num_decodeur =$request->num_decodeur;
        $data->duree = $request->duree;
        $data->id_materiel = $deco[0]->id_decodeur;
        $data->date_abonnement = $request->date_abonnement;
        $data->date_reabonnement = date_format(date_add(date_create("$request->date_abonnement"),date_interval_create_from_date_string("$request->duree months")),'Y-m-d');

        $date = new DateTime($data->date_reabonnement);
//        $date->sub(new DateInterval('P1D'));
        $date->sub(new DateInterval("P{$request->duree}D"));
        $date =  date("Y-m-d", strtotime($date->format('Y-m-d')));
        $data->date_reabonnement = $date;
        $date_reabonnement = $data->date_reabonnement;
        $data->id_user = $userid;
//        "237679353205",


        $client = Client::create([
            'nom_client'=>$data->nom_client,
            'num_abonne'=>$data->num_abonne,
            'prenom_client' =>$data->prenom_client,
            'adresse_client'=>$data->adresse_client,
            'duree' => $data->duree,
            'id_materiel' => $deco[0]->id_decodeur,
            'date_abonnement'=> $data->date_abonnement,
            'date_reabonnement'=>$data->date_reabonnement,
            'id_user'=>$data->id_user,
            'telephone_client'=>$data->telephone_client
        ]);
        $message_con ="";
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
        $data_pdf->total = $data->duree *  $formul[0]->prix_formule;
        $data_pdf->date_reabonnement = $data->date_reabonnement;
        $data_pdf->date_abonnement = $data->date_abonnement;
        $sendError = '';

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $data->date_abonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree *  $formul[0]->prix_formule;
        $data_message->id_client = $client->id_client;
        if (!empty($client)){
            $CD = ClientDecodeur::create(['id_decodeur'=>$deco[0]->id_decodeur,
                'id_client'=>$client->id_client,
                'id_user'=>$userid,
                'date_abonnement'=> $data->date_abonnement,
                'date_reabonnement'=>$date_reabonnement,
                'id_formule'=>$id_formule,
            ]);

            $reabonnement = Reabonnement::create(['id_decodeur'=>$deco[0]->id_decodeur,
                'id_client'=>$client->id_client,
                'id_formule'=>$id_formule,
                'id_user'=>$userid,
                'type_reabonement'=>1,
                'duree'=>$data->duree,
                'date_reabonnement'=>$date_reabonnement
            ]);
//                $message = ($request->nom_client." Merci de vous etre abonné chez nous! Formule: " .$request->formule . ", expire le: ".$data->date_reabonnement .".");
                $envoi = (new MessageController)->prepareMessage($data_message,'REABONNEMENT' );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $sendError =$envoi;
//                }

        }
//        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance() ;
        if (!empty($client) && $message_con!="") {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Solde SMS: '.$balance);
            $pdf = (new PDFController)->createPDF($data_pdf,$action);

            return  redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. Solde SMS: '.$balance);
        }

        if (!empty($client)  and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé. Solde SMS: '.$balance  );
            $pdf = (new PDFController)->createPDF($data_pdf,$action);
            return  redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.'."\n Statut: Solde SMS ".$balance);
        } else {
            session()->flash('message', 'Erreur! Le client n\' pas été enrgistré!');

            return redirect()->back()->with('danger', 'Erreur! Le client n\' pas été enrgistré!');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::where('id_client',$id)
            ->get();
        $user = User::where('id',$client[0]->id_user)->get();
        $decodeurs =ClientDecodeur::join('decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
            ->where('client_decodeurs.id_client',$id)->get();
        $reabonnements = Reabonnement::join('users','users.id','reabonnements.id_user')
            ->join('decodeurs','decodeurs.id_decodeur','reabonnements.id_decodeur')
            ->join('formules','formules.id_formule','reabonnements.id_formule')
            ->where('reabonnements.id_client',$id)
            ->OrderBy('id_reabonnement','DESC')
            ->get();
        $reabonnement= Reabonnement::where('id_client',$id)->get();
        return view('detailsclient',compact('client','decodeurs','reabonnements','user','reabonnement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteClient(Request $request)
    {
        $id = $request->id_client;
        $delete = Client::where('id_client',$id)->delete();
        return Response()->json($delete);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reabonne( $id_client)
    {
        $datas = Client::find($id_client);
        //dd($datas);
        $decos = Decodeur::join('client_decodeurs','client_decodeurs.id_decodeur','decodeurs.id_decodeur')
            ->where('client_decodeurs.id_client',$id_client)
            ->get();
        return view('new_reabonner',compact('datas','decos'));
    }

    public function edit_client( $id_client)
    {
        $datas = Client::find($id_client);
        $decodeurs = ClientDecodeur::join('decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
            ->where('id_client',$id_client)->get();
        //dd($datas);
        return view('modif_client',compact('datas','decodeurs'));
    }

    public function up_client( $id_client,$id_reabonnement)
    {

        $reabonnement = Reabonnement::where('id_reabonnement',$id_reabonnement)->get();
        $decodeur = Decodeur::where('id_decodeur',$reabonnement[0]->id_decodeur)->get();
        $decos = Decodeur::join('client_decodeurs','client_decodeurs.id_decodeur','decodeurs.id_decodeur')
            ->where('client_decodeurs.id_client',$id_client)
            ->get();
        return view('upgrade',[
            'datas' => Client::find($id_client),
            'reabonnement' => Reabonnement::where('id_reabonnement',$id_reabonnement)->get(),
            'formule' => Formule::where('id_formule',$reabonnement[0]->id_formule)->get(),
            'decodeur' => Decodeur::where('id_decodeur',$reabonnement[0]->id_decodeur)->get(),
            'decos'=>$decos
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateR(Request $request,$id_client)
    {
        $request->validate([
            'formule'=>'required',
            'date_reabonnement'=>'required',
            'id_decodeur'=>'required',
        ]);
        $data = Client::find($id_client);
        $formul = Formule::where('nom_formule',$request->formule)->get();
            $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();

        $action = "REABONNEMENT";

        if ($statutcaisse < $formul[0]->prix_formule * $request->duree){
            session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');

            return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');
        }
        $data->duree = $request->duree;
        $date_reabonnement = date_format(date_add(date_create("$request->date_reabonnement"),date_interval_create_from_date_string("$request->duree months")),'Y-m-d');

        $date = new DateTime($date_reabonnement);
        $date->sub(new DateInterval("P{$request->duree}D"));
        $date =  date("Y-m-d", strtotime($date->format('Y-m-d')));
        $data->date_reabonnement = $date;
        $date_reabonnement = $data->date_reabonnement;

        $date_abonnement = $request->date_reabonnement;
//        dd($data->date_reabonnement, $request->date_reabonnement);
//        DD($request);exit();
        $nom  =$request->nom_client;
        $userid= Auth::user()->id;
        $telephone = $request->telephone_client;
        $reabonnement = Reabonnement::create(['id_decodeur'=>$request->id_decodeur,
            'id_client'=>$id_client,
            'id_formule'=>$id_formule,
            'id_user'=>$userid,
            'type_reabonement'=>$request->type,
            'duree'=>$request->duree,
            'date_reabonnement'=>$date_reabonnement,
//            'id_decodeur'=>$request->id_decodeur
        ]);
        $decodeur = ClientDecodeur::where('id_decodeur',$request->id_decodeur)
                    ->where('id_client',$id_client)
                    ->update([
                            'date_reabonnement'=>$date_reabonnement,

                        ]);
//        $data = new Array_();
//        $data->name= 'desto';
//        $data->prenom= 'tambu';
//        $data->age= 10;
//        dd($data->prenom, $data->age, $data ->name);exit();

        $num_decodeur= Decodeur::where('id_decodeur',$request->id_decodeur)->get('num_decodeur');
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
        $data_pdf->total = $data->duree *  $formul[0]->prix_formule;
        $data_pdf->date_reabonnement = $date_reabonnement;
        $data_pdf->date_abonnement = $date_abonnement;

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $data->date_abonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree *  $formul[0]->prix_formule;
        $data_message->id_client = $id_client;
//        DD($request); exit();
        if ($reabonnement){
            $message_con ='';
            $storeCaisse = (new CaisseController)->creditCaisse($reabonnement->id,'REABONNEMENT',$data->duree *  $formul[0]->prix_formule);

            $message = $nom." Votre réabonnement à été effectué avec success! Formule: " .$request->formule . ", expire le: ".$data->date_reabonnement .".";
                $envoi = (new MessageController)->prepareMessage($data_message,'REABONNEMENT' );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $message_con ="Erreur d'envoie du message".$envoi;
//                }
        }
        //        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance() ;
//        $data->save();
        $pdf = (new PDFController)->createPDF($data_pdf,$action);
        session()->flash('message', 'Le reabonnement a reussi. Solde SMS: '.$balance);
        return  redirect()->route('review.reabonner')->with('info', 'Le reabonnement a reussi. Solde SMS: '.$balance);
    }

    public function upgradeClient(Request $request,$id_client)
    {
        $request->validate([
            'formule'=>'required',
        ]);
        $data = Client::find($id_client);
        $dt = Reabonnement::where('id_client',$request->id_reabonnement)->get();
        $formule = Formule::where('id_formule',$request->id_formule)->get();
        $formul = Formule::where('nom_formule',$request->formule)->get();
            $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();
        $difference = $formul[0]->prix_formule - $formule[0]->prix_formule;
        if ( $difference > 0){
            if ($statutcaisse < $difference){
                session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');

                return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');
            }
        }
        $userid= Auth::user()->id;
        $reabonnement = Reabonnement::where('id_reabonnement',$request->id_reabonnement)
            ->update(['id_decodeur'=>$request->id_decodeur,
            'id_formule'=>$id_formule,
            'id_user'=>$userid,
            'type_reabonement'=>$request->type,
        ]);
        $data_pdf = new Array_();
        $data_pdf->nom_client = $data->nom_client;
        $data_pdf->prenom_client = $data->prenom_client;
        $data_pdf->num_abonne = $data->num_abonne;
        $data_pdf->telephone_client = $data->telephone_client;
        $data_pdf->dureeA = 0;
        $data_pdf->dureeR = 0;
        $data_pdf->dureeU = 1;
//        $data_pdf->dureeU = $data->duree;
        $data_pdf->num_decodeur = $request->num_decodeur;
        $data_pdf->nom_formule = $request->formule;
        $data_pdf->prix_formuleU = $difference;
        $data_pdf->prix_formuleR = 0;
        $data_pdf->prix_formuleA = 0;
        $data_pdf->total = $data->duree*$difference;
        $data_pdf->date_reabonnement = $request->date_reabonnement;
        $data_pdf->date_abonnement = "";

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = "";
        $data_message->dateecheance = $request->date_reabonnement;
        $data_message->montant = $data->duree*$difference;
        $data_message->id_client = $id_client;

        if ($reabonnement){
            $message_con ='';
//            $storeCaisse = (new CaisseController)->creditCaisse($reabonnement->id,'REABONNEMENT',$request->montant_versement * -1);
                $message = $data->nom_client." Mis à jour de la formule réussi ! Formule: " .$request->formule . ", expire le: ".$data->date_reabonnement .".";
                $envoi = (new MessageController)->prepareMessage($data_message,'REABONNEMENT' );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $message_con ="Erreur d'envoie du message".$envoi;
//                }
        }
//        $data->save();
        //        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance() ;
        $pdf = (new PDFController)->createPDF($data_pdf,'UPGRADE');
        session()->flash('message', "L'upgrate du client a reussi. Solde SMS: ".$balance);
        return  redirect()->route('upgrader')->with('info', "L'upgrate du client a reussi. Solde SMS: ".$balance);
    }



    public function storeDecCli(Request $request,$id_client)
    {
        $data = Client::find($id_client);
        $formul = Formule::where('nom_formule',$request->formule)->get();
        $formule_actuel = ClientDecodeur::find($id_client);
        $deco = Decodeur::where('num_decodeur',$request->num_decodeur)->get();
        $clientdeco = ClientDecodeur::where('id_decodeur',$request->num_decodeur)->get();
        $date_rea = date_format(date_add(date_create("$request->date_abonnement"),date_interval_create_from_date_string("$request->duree months")),'Y-m-d');

//        Auth::user()->role==='admin';
        $userid= Auth::user()->id;


        if (empty($deco)){
            session()->flash('message', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre.');

            return redirect()->back()->with('warning', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre!');
        }

                if(!empty($clientdeco[0])){
                session()->flash('message', ' Ce décodeur est déja utilisé par client!');

                return redirect()->back()->with('warning', 'Ce décodeur est déja utilisé par client!');
            }


//        foreach($formul as $formul1){
            $id_formule = $formul[0]->id_formule;
//        }
//        "237679353205",
//        $id_formule = $formul[0]->id_formule;

        $statutcaisse = (new VersementController)->resteVersement();
       // if($formul[0]->prix_formule >)
        if ($statutcaisse < $formul[0]->prix_formule){
            session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');

            return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');
        }
        $message_con ="";
//        DD($client->id_client);exit();
        $sendError = "";


        if (!empty($client)){
            $CD = ClientDecodeur::create(['id_decodeur'=>$deco[0]->id_decodeur,
            'id_client'=>$data->id_client,
            'id_formule'=>$id_formule,
            'date_abonnement'=> $request->date_abonnement,
            'date_reabonnement'=>$date_rea,
            'id_user'=>$data->id_user,
            ]);

            $reabonnement = Reabonnement::create(['id_decodeur'=>$deco[0]->id_decodeur,
                'id_client'=>$data->id_client,
                'id_formule'=>$id_formule,
                'id_user'=>$userid,
                'type_reabonement'=>1,
                'duree'=>$data->duree,
                'date_reabonnement'=>$date_rea,
            ]);
                $message = ($data->nom_client." Merci de vous etre abonné chez nous! Formule: " .$request->formule . ", expire le: ".$date_rea .".");
                $envoi = (new MessageController)->sendMessage($message,$data->telephone_client );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $sendError =$envoi;
//                }

        }
//        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance() ;
        if (!empty($client) && $message_con!="") {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Solde SMS '.$balance);
            //$pdf = (new PDFController)->createPDF($data);
            return  redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. '.$balance);
        }

        if (!empty($client)  and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé '  );
            return  redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.'+"\n Statut: Solde SMS: ".$balance);
        } else {
            session()->flash('message', 'Erreur! Le client n\' pas été enrgistré!');

            return redirect()->back()->with('danger', 'Erreur! Le client n\' pas été enrgistré!');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('info','Le client a été effacé avec succès.');
    }


    public function mesAbonnements(){
        $userid= Auth::user()->id;
        $data = Decodeur::join('client_decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
            ->join('formules','client_decodeurs.id_formule','formules.id_formule')
            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.id_user',$userid)
            ->get();
        return view("users.mes_abonnements",compact('data'));
    }
    public function mesAbonnementsjour(){
        $userid= Auth::user()->id;
        $data = Decodeur::join('client_decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
            ->join('formules','client_decodeurs.id_formule','formules.id_formule')
            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_abonnement',date('Y-m-d'))
            ->where('client_decodeurs.id_user',$userid)
            ->get();
   //     dd($data);exit();
        return view("users.abonnementsjours",compact('data'));
    }

    public function allReabonnement(){
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs','decodeurs.id_decodeur','reabonnements.id_decodeur')
            ->OrderBy('reabonnements.id_reabonnement','DESC')
            ->get();
        $reabonnement = Reabonnement::all();
        return view("users.allreabonnement", compact('data','reabonnement'));
    }
    public function creditReabonnement(){
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs','decodeurs.id_decodeur','reabonnements.id_decodeur')
            ->where('reabonnements.type_reabonement',0)
            ->OrderBy('reabonnements.id_reabonnement','DESC')
            ->get();
        $reabonnement = Reabonnement::all();
        return view("users.reabonnements_credit", compact('data','reabonnement'));
    }

    public function mesReabonnements(){
        $userid = Auth::user()->id;
        $date = date("Y-m-d");
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs','decodeurs.id_decodeur','reabonnements.id_decodeur')
            ->where('reabonnements.id_user', $userid)
            ->OrderBy('reabonnements.id_reabonnement','DESC')
            ->get();
        $reabonnement = Reabonnement::all();
//            ->get('reabonnements.*','decodeurs.id_decodeur','decodeurs.num_decodeur','formules.nom_formule','formules.prix_formule',
//                'clients.nom_client','clients.prenom_client','clients.num_abonne','clients.telephone_client'
//            );
        return view("users.mes_reabonnements", compact('data','reabonnement'));
    }
    public function mesReabonnementsAjour()
    {
        $userid = Auth::user()->id;
        $date = date("Y-m-d");
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs','decodeurs.id_decodeur','reabonnements.id_decodeur')
            ->where('reabonnements.created_at', 'LIKE', "%{$date}%")
            ->where('clients.id_user', $userid)
            ->OrderBy('reabonnements.id_reabonnement','DESC')
            ->get();
//        return view("users.mes_reabonnementsjour", compact('data'));
        return view("users.mes_reabonnementsjour", compact('data'));
    }

    public function nouveauClient(){
//        $envoi = (new MessageController)->sendMessage("237679353205","" );

        $userid= Auth::user()->id;
        $data = Decodeur::join('client_decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
//         ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('formules','client_decodeurs.id_formule','formules.id_formule')
            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement','>=',date('Y-m-d'))
//         ->where('client_decodeurs.id_user',$userid)
            ->get();
        $messages = (new MessageController)->getStandart();
        return view("users.clientNouveau", compact('data','messages'));
    }

    public function bientotATerme(){
        $date_reabonnement = date_format(date_add(date_create(date("Y-m-d")),date_interval_create_from_date_string("3 days")),'Y-m-d');

        $data = Decodeur::join('client_decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
            ->join('formules','client_decodeurs.id_formule','formules.id_formule')
            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement','<=',$date_reabonnement)
            ->where('client_decodeurs.date_reabonnement','>=',date('Y-m-d'))
//         ->where('client_decodeurs.id_user',$userid)
            ->get();
        $messages = (new MessageController)->getStandart();
        return view("users.bientoTerme", compact('data','messages'));
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
        $messages = (new MessageController)->getStandart();
        return view("users.clientPerdu", compact('data','messages'));
    }

    public function relancerClient($numero){
        $message = "Votre abonnement canal+ a expiré. Nous vous prions de vous reabonner.";
        $envoi = (new MessageController)->sendMessage($message,$numero );
        if ($envoi==0){
            session()->flash('message', 'Client relancé avec succès!');

            return redirect()->back()->with('success', 'Client relancé avec succès!');
        }else{
            session()->flash('message', 'Echec de l\'envoi du message!');

            return redirect()->back()->with('danger', 'Echec de l\'envoi du message!');
        }

    }

    public function deleteReabonne( Request $request){
        $id = $request->id;
        $delete = Reabonnement::where('id_reabonnement',$id)->delete();
        $storeCaisse = (new CaisseController)->removerFromCaisse($id,'REABONNEMENT');
//        $storeCaisse = (new CaisseController)->creditCaisse($reabonnement->id,'REABONNEMENT',$data->duree *  $formul[0]->prix_formule);

        return Response()->json($delete);
    }

    public function recoverReabonne( Request $request){
        $id = $request->id;
        $delete = Reabonnement::where('id_reabonnement',$id)->update(['type_reabonement'=>1]);
        return Response()->json($delete);
    }

    public function deleteAbonne( Request $request){
        $id = $request->id_client;
        $delete = ClientDecodeur::where('id_client',$id)->delete();
        $deletec = Client::where('id_client',$id)->delete();
        return Response()->json($delete);
    }

    public function newDecodeur(Request $request){

        $userid= Auth::user()->id;
        $clients = Client::where('id_client',$request->id_client)->get();
        $formul = Formule::where('nom_formule',$request->formule)->get();
        $deco = Decodeur::where('num_decodeur',$request->num_decodeur)->get();
        if(!empty($deco[0])) {
            $clientdeco = ClientDecodeur::where('id_decodeur', $deco[0]->id_decodeur)->get();
        }
        $data = new client;
        $action = "ABONNEMENT";
//        $id_decodeur = 0;

        $data->telephone_client = $clients[0]->telephone_client;


        if(!empty($clientdeco[0])){
            session()->flash('message', ' Ce décodeur est déja utilisé par client!');

            return redirect()->back()->with('warning', 'Ce décodeur est déja utilisé par client!');
        }

        if (!empty($deco[0])){
            $id_decodeur = $deco[0]->id_decodeur;
            $prix_decodeur = $deco[0]->prix_decodeur;
        }else{
            $deco = Decodeur::create([
               'num_decodeur'=> $request->num_decodeur,
               'quantite'=>1,
               'prix_decodeur'=>$request->prix_decodeur,
               'date_livaison'=>date('Y-m-d'),
               'id_user'=>$userid
            ]);
            $id_decodeur = $deco->id;

            $prix_decodeur = $request->prix_decodeur;
        }

//        $data->id_decodeur = $deco[0]->id_decodeur;
//        foreach($formul as $formul1){
        $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new VersementController)->resteVersement();
        if ($statutcaisse < $formul[0]->prix_formule * $request->duree){
            session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');

            return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');
        }
//        }
        $data->nom_client = $clients[0]->nom_client;
        $data->num_abonne = $clients[0]->num_abonne;
        $data->prenom_client = $clients[0]->prenom_client;
        $data->adresse_client = $clients[0]->adresse_client;
        $data->num_decodeur =$request->num_decodeur;
        $data->duree = $request->duree;
        $data->id_materiel = $id_decodeur;
        $data->date_abonnement = $request->date_abonnement;
        $data->date_reabonnement = date_format(date_add(date_create("$request->date_abonnement"),date_interval_create_from_date_string("$request->duree months")),'Y-m-d');
        $date = new DateTime($data->date_reabonnement);
//        $date->sub(new DateInterval('P1D'));
        $date->sub(new DateInterval("P{$request->duree}D"));
        $date =  date("Y-m-d", strtotime($date->format('Y-m-d')));
        $data->date_reabonnement = $date;
        $date_reabonnement=$data->date_reabonnement;
        $data->id_user = $userid;

        $message_con ="";

        $data_pdf = new Array_();
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
        $data_pdf->total = $data->duree *  $formul[0]->prix_formule + $prix_decodeur;
        $data_pdf->date_reabonnement = $data->date_reabonnement;
        $data_pdf->date_abonnement = $data->date_abonnement;
        $sendError = '';

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo = $data->date_abonnement;
        $data_message->dateecheance = $data->date_reabonnement;
        $data_message->montant = $data->duree *  $formul[0]->prix_formule+ $prix_decodeur;
        $data_message->id_client = $request->id_client;

        if (!empty($request->id_client)){
            $CD = ClientDecodeur::create(['id_decodeur'=>$id_decodeur,
                'id_client'=>$request->id_client,
                'id_user'=>$userid,
                'date_abonnement'=> $data->date_abonnement,
                'date_reabonnement'=>$date_reabonnement,
                'id_formule'=>$id_formule,
            ]);

            $reabonnement = Reabonnement::create(['id_decodeur'=>$id_decodeur,
                'id_client'=>$request->id_client,
                'id_formule'=>$id_formule,
                'id_user'=>$userid,
                'type_reabonement'=>1,
                'duree'=>$data->duree,
                'date_reabonnement'=>$date_reabonnement
            ]);
//                $message = ($request->nom_client." Merci de vous etre abonné chez nous! Formule: " .$request->formule . ", expire le: ".$data->date_reabonnement .".");
                $envoi = (new MessageController)->prepareMessage($data_message,'ABONNEMENT' );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $sendError =$envoi;
//                }

        }
//        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance() ;
        if (!empty($reabonnement) && !empty($CD)) {
            session()->flash('message', 'Enregistré avec succès. Solde SMS: '.$balance);
            $pdf = (new PDFController)->createPDF($data_pdf,$action);

            return  redirect()->back()->with('info', 'Enregistré avec succès. Solde SMS: '.$balance);
        }

        if (!empty($reabonnement)  and empty($message_con)) {
            session()->flash('message', 'Enregistré avec succès. Mais le message n\'a pas été envoyé. solde SMS: '.$balance  );
            $pdf = (new PDFController)->createPDF($data_pdf,$action);
            return  redirect()->back()->with('warning', 'Enregistré avec succès. Mais le message n\'a pas été envoyé.'."\n Statut: solde SMS: ".$balance);
        } else {
            session()->flash('message', 'Erreur lors de l\'enregistrement!');

            return redirect()->back()->with('danger', 'Erreur lors de l\'enregistrement!');
        }

    }
}
