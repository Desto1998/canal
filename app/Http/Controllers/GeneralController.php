<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\ClientDecodeur;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Materiel;
use App\Models\Reabonnement;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Supporzt\Facades\Http;
//use GuzzleHttp\Client;
class GeneralController extends Controller
{
    public function dashboard()
    {
//        $client = new Client();
//        $client = new Client();
//        $sendurl = 'https://smsvas.com/bulk/public/index.php/api/v1/sendsms';
//       $sendurl = 'https://smsvas.com/bulk/public/index.php/api/v1/sendsms?user=teneyemdesto@gmail.com&password=getel2021&senderid=Getel&sms=Bonjour&mobiles=679353205&scheduletime=yyyy-MM-dd%25hh:mm:ss';
//        $balanceurl = 'https://smsvas.com/bulk/public/index.php/api/v1/smscredit';
//        $headers = [
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
//        ];
//        $data = [
//            "user "=> "teneyemdesto@gmail.com",
//            "password"=> "getel2021",
//        ];
//        $response = $client->request('POST', $balanceurl,
//            [
//                'headers' => $headers,
//                'json' => $data
//            ]
//        );
//        $balanceurl = 'https://smsvas.com/bulk/public/index.php/api/v1/smscredit?user=teneyemdesto@gmail.com&password=getel2021';
//        $response = Http::get($balanceurl);
//        $response = Http::get($sendurl);

//        $response = Http::post($balanceurl, [
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
//            "user"=> "teneyemdesto@gmail.com",
//             "password"=> "getel2021"
//        ]);
//        $response = Http::post('https://smsvas.com/bulk/public/index.php/api/v1/sendsms', [
//            'Accept' => 'application/json',
//            'Content-Type' => 'application/json',
//            "user"=> "teneyemdesto@gmail.com",
//            "password"=> "getel2021",
//             "senderid"=> "Getel",
//             "sms"=> "Bonjour desto",
//             "mobiles"=> "237679353205"
//        ]);
//        $send = (new MessageController)->sendMessage('Test Message','679353205');
        $balance = (new MessageController)->getSMSBalance() ;
        $allFormules = Formule::all();
        $decodeurs= Decodeur::all();
        $reabonnements = Reabonnement::all();
        $clients = Client::All();
        $decodeuroccupe = ClientDecodeur::all();
        $materiels= Materiel::all();
        $users = User::all();
        $caisse = Caisse::all();
        $totalCaisse  = (new MessageController)->totalCaisse();
        $statutcaisse = (new MessageController)->resteCaisse();
//        $difference = (new MessageController)->resteCaisse();
        $consommeCaisse = (new MessageController)->dejaConsomme();
        $totalVersement  = (new VersementController)->totalVersement();
        $statutVersement = (new VersementController)->resteVersement();
//        $difference = (new MessageController)->resteCaisse();
        $consommeVersement = (new VersementController)->dejaUtilise();
        $clientnouveaux = $this->nouveauClient();
        $clientperdu = $this->clientPerdu();
        $bientotaterme = $this->bientATerme();
        return view('dashboard',compact('allFormules','reabonnements','decodeurs','clients',
            'decodeuroccupe','materiels','materiels','users','caisse','totalCaisse','statutcaisse','consommeCaisse'
            ,'clientnouveaux','clientperdu','bientotaterme','balance','totalVersement','statutVersement','consommeVersement'
        ));
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
        return $data;
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
        return $data;
    }

    // abonne bienetot a terme dans 3
    public function bientATerme(){

        $date_reabonnement = date_format(date_add(date_create(date("Y-m-d")),date_interval_create_from_date_string("3 days")),'Y-m-d');

        $data = ClientDecodeur::join('clients','clients.id_client','client_decodeurs.id_client')
//            ->join('clients','clients.id_client','client_decodeurs.id_client')
            ->where('client_decodeurs.date_reabonnement','<=',$date_reabonnement)
            ->get();
        return $data;
    }

    public function rechercherGlobal(Request  $request){
        if (empty($request->research)){
            return redirect()->back()->with('warning','Mauvaise valeur de saisie.');

        }
        $rechercher = strtotime($request->research);
        $research = Client::where('nom_client','LIKE', "%{$request->research}%")
            ->orWhere('telephone_client', 'LIKE', "%{$request->research}")
            ->orWhere('num_abonne','=', $request->research)
            ->get();
        if (count($research)===0){
            return redirect()->back()->with('warning','Auccun résultat trouvé pour: <<'.$request->research.'>>');
        }
        if (count($research)===1){
            return (new ClientController)->show($research[0]->id_client);
        }else{

            $data  = $research;
            $messages = (new MessageController)->getStandart();

            return view('globalresearchresult',compact('data','messages'));

        }

    }
}
