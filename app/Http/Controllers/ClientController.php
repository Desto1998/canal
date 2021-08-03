<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Formule;
use App\Models\Message;
use App\Models\User;
use App\Models\Materiel;
use App\Models\Decodeur;
use Vonage\Client\Exception\Exception;
use App\Http\Controllers\MessageController;

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
        $allClients = Client::paginate(5);
        return view('abonner',compact('allClients','allFormules'));
    }

    public function review()
    {
        $allClients = Client::all();
        $allFormules = Formule::all();
        $allClients = Client::paginate(5);
        return view('reabonner',compact('allClients','allFormules'));
    }

    public function allview()
    {
        $allClients = Client::all();
        $allFormules = Formule::all();
        $allClients = Client::paginate(5);
        return view('clients',compact('allClients','allFormules'));
    }

    public function viewModif()
    {
        $allClients = Client::paginate(5);
        return view('modifier',[
            'allClients' => Client::all(),
            'allFormules' => Formule::all(),
            'allMateriels' => Materiel::all(),
            'allDecodeurs' => Decodeur::all(),
            'allUsers' => User::all(),
            'allMessages' => Message::all(),
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
    public function create()
    {

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
        $data = new client;
        $data->nom_client = $request->nom_client;
        $data->prenom_client = $request->prenom_client;
        $data->num_abonne = $request->num_abonne;
        $data->adresse_client = $request->adresse_client;
        if (!empty($deco)){
            session()->flash('message', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre.');

            return redirect()->back()->with('warning', ' Le décodeur n\'existe pas! Veillez l\'enregistrer ou entrez un autre!');
        }
        foreach($clients as $cli){
            if($cli->telephone_client != $request->telephone_client or $cli->telephone_client=null){
                $data->telephone_client = $request->telephone_client;
            }
            else{
//                echo"Client existant";
                session()->flash('message', ' Le client existe déja!');

                return redirect()->back()->with('warning', 'Le client existe déja!');
            }
        }

        foreach($deco as $dec){
                $data->id_decodeur = $dec->id_decodeur;
                $data->id_materiel = $dec->id_materiel;
        }

        foreach($formul as $formul1){
            $data->id_formule = $formul1->id_formule;
        }

        $data->date_abonnement = $request->date_abonnement;
        $data->date_reabonnement = $request->date_abonnement;
//        "237679353205",

        $client = $data->save();
        $message_con ="";

        if (!empty($client)){
            $message = 'Merci de vous etre abonné chez nous!';
            $envoi = (new MessageController)->sendMessage($message,$request->telephone_client );
            if ($envoi == 0) {
                $message_con ="Un message a été envoyé au client";
            }else{
                $message_con = $envoi;
            }
//            try {
//                $basic  = new \Vonage\Client\Credentials\Basic("955fc9c6", "mAWAdKoZ6Emoe6QU");
//                $client = new \Vonage\Client($basic);
//                $response = $client->sms()->send(
//                    new \Vonage\SMS\Message\SMS(
//                        $request->telephone_client,
//                        'GETEL',
//                        'Merci de vous etre abonné chez nous!')
//                );
//                $message = $response->current();
//
//                if ($message->getStatus() == 0) {
//                    $message_con ="Un message a été envoyé au client";
//                }
//            } catch (Exception $e) {
//            $sendError = "Error: ". $e->getMessage();
//        }

        }
        $notification = array(
            'message' => 'Données insérées avec succès',
            'alert-type' =>'success'
        );
        if (!empty($client) && !empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données.');
            return  redirect()->back()->with('info', 'Le client a bien été enregistré dans la base de données. et'+$message_con);
        }

        if (!empty($client)  and empty($message_con)) {
            session()->flash('message', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé'  );
            return  redirect()->back()->with('warning', 'Le client a bien été enregistré dans la base de données. Mais le message n\'a pas été envoyé.'+"\n Statut: "+ $message_con);
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
        //return view('abonner',compact('client'));
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
        return view('new_reabonner',compact('datas'));
    }

    public function edit_client( $id_client)
    {
        $datas = Client::find($id_client);
        //dd($datas);
        return view('modif_client',compact('datas'));
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
        // $data -> nom_client = $request->nom_client;
        // $data -> prenom_client = $request->prenom_client;
        // $data -> adresse_client = $request->adresse_client;
        //$data -> telephone_client = $request->telephone_client;
        foreach($formul as $formul1){
            $data -> id_formule = $formul1->id_formule;
        }
        // $data -> date_abonnement = $request->date_abonnement;
        $data -> date_reabonnement = $request->date_reabonnement;

        $data->save();
        //$client->update($request->all());
        return redirect()->route('review.reabonner')->with('info', 'Le réabonnement a reussi');
    }
    public function updateM(ClientRequest $request,$id_client)
    {
        $data = Client::find($id_client);
        $deco = Decodeur::where('num_decodeur',$request->num_decodeur)->get();
        $formul = Formule::where('nom_formule',$request->formule)->get();
        $data -> nom_client = $request->nom_client;
        $data -> prenom_client = $request->prenom_client;
        $data -> adresse_client = $request->adresse_client;
        $data -> telephone_client = $request->telephone_client;
        foreach($deco as $dec){
            $data->id_decodeur = $dec->id_decodeur;
            $data->id_materiel = $dec->id_materiel;
    }
        foreach($formul as $formul1){
            $data -> id_formule = $formul1->id_formule;
        }
        $data -> date_reabonnement = $request->date_reabonnement;

        $data->save();
        //$client->update($request->all());
        return redirect()->route('modifier')->with('info', 'La modification a reussi');
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




}
