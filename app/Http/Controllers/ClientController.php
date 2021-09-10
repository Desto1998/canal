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
        return view('clients',compact('allClients','allFormules'));
    }

    public function viewModif()
    {
        return view('upgrader',[
            'allClients' => Client::all(),
            // 'allFormules' => Formule::all(),
            // 'allMateriels' => Materiel::all(),
            // 'allDecodeurs' => Decodeur::all(),
            // 'allUsers' => User::all(),
            // 'allMessages' => Message::all(),
        ]);
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
//        dd($client);
        if ($client){
            return redirect()->route('clients')->with('success','Effectue avec succes');
        }else{
            return redirect()->back()->with('warning',"Echec lors de l'enregistrement!");

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
        $clientdeco = ClientDecodeur::where('id_decodeur',$request->num_decodeur)->get();
        $data = new client;
        $action = "ABONNEMENT";


//        Auth::user()->role==='admin';
        $userid= Auth::user()->id;


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
             $statutcaisse = (new MessageController)->resteCaisse();
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
//                $envoi = (new MessageController)->sendMessage($message,$request->telephone_client );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $sendError =$envoi;
//                }

        }

        if (!empty($client) && $message_con!="") {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. '.$message_con);
            $pdf = (new PDFController)->createPDF($data_pdf,$action);

            return  redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. '.$message_con);
        }

        if (!empty($client)  and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé '.$sendError  );
            $pdf = (new PDFController)->createPDF($data_pdf,$action);
            return  redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.'."\n Statut:".$sendError);
        } else {
            session()->flash('message', 'Erreur! Le client n\' pas été enrgistré!');

            return redirect()->back()->with('danger', 'Erreur! Le client n\' pas été enrgistré!');
        }
    }

    public function reabonneAdd(Request $request)
    {
        $userid= Auth::user()->id;
        $decora = Decodeur::create([
            'num_decodeur'=>$request->num_decodeur,
            'prix_decodeur'=>0,
            'date_livaison'=>'2021-08-17',
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
        $statutcaisse = (new MessageController)->resteCaisse();
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
//                $envoi = (new MessageController)->sendMessage($message,$request->telephone_client );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $sendError =$envoi;
//                }

        }

        if (!empty($client) && $message_con!="") {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. '.$message_con);
            $pdf = (new PDFController)->createPDF($data_pdf,$action);

            return  redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. '.$message_con);
        }

        if (!empty($client)  and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé '.$sendError  );
            $pdf = (new PDFController)->createPDF($data_pdf,$action);
            return  redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.'."\n Statut:".$sendError);
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
        //dd($datas);
        return view('modif_client',compact('datas'));
    }

    public function up_client( $id_client)
    {
        $datas = Client::find($id_client);
        $formule = Formule::where('id_formule',$datas->id_formule)->get();
        $decodeur = Decodeur::where('id_decodeur',$datas->id_decodeur)->get();
        $decos = Decodeur::join('client_decodeurs','client_decodeurs.id_decodeur','decodeurs.id_decodeur')
            ->where('client_decodeurs.id_client',$id_client)
            ->get();
        return view('upgrade',[
            'datas' => Client::find($id_client),
            'formule' => Formule::where('id_formule',$datas->id_formule)->get(),
            'decodeur' => Decodeur::where('id_decodeur',$datas->id_decodeur)->get(),
            'decos'=>$decos,
            // 'allDecodeurs' => Decodeur::all(),
            // 'allUsers' => User::all(),
            // 'allMessages' => Message::all(),
        ]);
        //return view('upgrade',compact('datas','formule','decodeur'));
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
        ]);
        $data = Client::find($id_client);
        $formul = Formule::where('nom_formule',$request->formule)->get();
            $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new MessageController)->resteCaisse();

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
//        DD($request); exit();
        if ($reabonnement){
            $message_con ='';
                $message = $nom." Votre réabonnement à été effectué avec success! Formule: " .$request->formule . ", expire le: ".$data->date_reabonnement .".";
//                $envoi = (new MessageController)->sendMessage($message,$telephone );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $message_con ="Erreur d'envoie du message".$envoi;
//                }
        }
//        $data->save();
        $pdf = (new PDFController)->createPDF($data_pdf,$action);
        session()->flash('message', 'Le reabonnement a reussi. '.$message_con);
        return  redirect()->route('review.reabonner')->with('info', 'Le reabonnement a reussi.'.$message_con);
    }

    public function upgradeClient(Request $request,$id_client)
    {
        $request->validate([
            'formule'=>'required',
        ]);
        $data = Client::find($id_client);

        $action = "UPGRADE";

        $dt = Reabonnement::where('id_client',$id_client)->get();
        $formule = Formule::where('id_formule',$dt[0]->id_formule)->get();
        $formul = Formule::where('nom_formule',$request->formule)->get();
            $id_formule = $formul[0]->id_formule;
        $statutcaisse = (new MessageController)->resteCaisse();
        $difference = $formul[0]->prix_formule - $formule[0]->prix_formule;
        if ( $difference > 0){
            if ($statutcaisse < $difference){
                session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');

                return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');
            }
        }
        $userid= Auth::user()->id;
        $reabonnement = Reabonnement::create(['id_decodeur'=>$request->id_decodeur,
            'id_client'=>$id_client,
            'id_formule'=>$id_formule,
            'id_user'=>$userid,
            'type_reabonement'=>$request->type,
            'id_decodeur'=>$request->id_decodeur,
            'duree'=>$dt[0]->duree,
            'date_reabonnement'=>$dt[0]->date_reabonnement,
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
        $data_pdf->date_reabonnement = $dt[0]->date_reabonnement;
        $data_pdf->date_abonnement = "";
        if ($reabonnement){
            $message_con ='';
                $message = $data->nom_client." Mis à jour de la formule réussi ! Formule: " .$request->formule . ", expire le: ".$data->date_reabonnement .".";
//                $envoi = (new MessageController)->sendMessage($message,$data->telephone_client );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $message_con ="Erreur d'envoie du message".$envoi;
//                }
        }
//        $data->save();
        $pdf = (new PDFController)->createPDF($data_pdf,$action);
        session()->flash('message', "L'upgrate du client a reussi. ".$message_con);
        return  redirect()->route('upgrader')->with('info', "L'upgrate du client a reussi. ".$message_con);
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

        $statutcaisse = (new MessageController)->resteCaisse();
       // if($formul[0]->prix_formule >)
        if ($statutcaisse < $formul[0]->prix_formule){
            session()->flash('message', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');

            return redirect()->back()->with('warning', 'Le montant en caisse n\'est pas suffisant pour cette opération! il ne reste que: ' .$statutcaisse.' FCFA en caisse.');
        }
        $message_con ="";
//        DD($client->id_client);exit();



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
//                $envoi = (new MessageController)->sendMessage($message,$data->telephone_client );
//                if ($envoi == 0) {
//                    $message_con ="Un message a été envoyé au client.";
//                }else{
//                    $sendError =$envoi;
//                }

        }

        if (!empty($client) && $message_con!="") {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. '.$message_con);
            //$pdf = (new PDFController)->createPDF($data);
            return  redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. '.$message_con);
        }

        if (!empty($client)  and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé '.$sendError  );
            return  redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.'+"\n Statut:".$sendError);
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
        $envoi = (new MessageController)->sendMessage("237679353205","" );

        $userid= Auth::user()->id;
        $data = Decodeur::join('client_decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
//         ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('formules','client_decodeurs.id_formule','formules.id_formule')
            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement','>=',date('Y-m-d'))
//         ->where('client_decodeurs.id_user',$userid)
            ->get();
        return view("users.clientNouveau", compact('data'));
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
        return view("users.clientPerdu", compact('data'));
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
        return Response()->json($delete);
    }
}
