<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Caisse;
use App\Models\ClientDecodeur;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Materiel;
use App\Models\Reabonnement;
use App\Models\Client;
use App\Models\Type_operation;
use App\Models\Upgrade;
use App\Models\User;
use App\Models\Versement;
use App\Models\Versement_achats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Supporzt\Facades\Http;
use PDF;

//use GuzzleHttp\Client;
class GeneralController extends Controller
{
    public function dashboard()
    {

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

        $data = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('formules', 'client_decodeurs.id_formule', 'formules.id_formule')
            ->join('clients', 'clients.id_client', 'client_decodeurs.id_client')
            ->where('client_decodeurs.date_abonnement', date('Y-m-d'))
            ->get()
        ;
        $date=date('Y-m-d');
        $abonnementstoday = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
            ->join('clients', 'abonnements.id_client', 'clients.id_client')
            ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('users', 'abonnements.id_user', 'users.id')
            ->where('abonnements.created_at','LIKE', "{$date}%")
            ->OrderBy('id_abonnement','DESC')
            ->get()
        ;
        $reabonnementstoday = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->where('reabonnements.created_at', 'LIKE', "%{$date}%")
            ->join('users', 'reabonnements.id_user', 'users.id')
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get()
        ;
        $upgradestody = Upgrade::join('users', 'upgrades.id_user', 'users.id')
            ->join('formules', 'formules.id_formule', 'upgrades.id_oldformule')
            ->where('upgrades.created_at', 'LIKE', "%{$date}%")
            ->OrderBy('id_upgrade', 'DESC')
            ->get()
        ;
        $totalCredit = $this->CalculTotalCredit();
        return view('dashboard',compact('allFormules','reabonnements','decodeurs','clients',
            'decodeuroccupe','materiels','materiels','users','caisse','totalCaisse','statutcaisse','consommeCaisse'
            ,'clientnouveaux','clientperdu','bientotaterme','balance','totalVersement','statutVersement','consommeVersement',
            'upgradestody','reabonnementstoday','abonnementstoday','totalCredit'

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
            ->where('client_decodeurs.date_reabonnement','>=',date('Y-m-d'))
            ->get()
        ;
        return $data;
    }

    public function rechercherGlobal(Request  $request){
        if (empty($request->research)){
            return redirect()->back()->with('warning','Mauvaise valeur de saisie.');

        }
        $rechercher = strtotime($request->research);
        $research = Client::where('nom_client','LIKE', "%{$request->research}%")
            ->orWhere('telephone_client', 'LIKE', "%{$request->research}%")
            ->orWhere('adresse_client','LIKE', "%{$request->research}%")
            ->orWhere('prenom_client','=', "%{$request->research}%")
            ->get()
        ;
        if (count($research)===0){
            $infos = ClientDecodeur::join('decodeurs','decodeurs.id_decodeur','client_decodeurs.id_decodeur')
                ->where('num_abonne','LIKE',"%{$request->research}%")
                ->orWhere('num_decodeur','LIKE', "%{$request->research}%")
                ->get();
            $id_client = [];
            if (count($infos)>0)
            {
                foreach ($infos as $key=> $value){
                    $id_client[$key]=$value->id_client;
                }

                $research = Client::whereIn('id_client',$id_client)
                    ->get()
                ;
            }else{
                return redirect()->route('client.add.form')->with('warning','Auccun résultat trouvé pour: <<'.$request->research.'>>. Veillez l\'ajouter!');

            }

        }
        if (count($research)===1){
            return (new ClientController)->show($research[0]->id_client);
        }else{

            $data  = $research;
            $messages = (new MessageController)->getStandart();

            return view('globalresearchresult',compact('data','messages'));

        }

    }
    public function getUsers()
    {
        $userid = Auth::user()->id;
        $users =User::where('id','!=',$userid)->get();
//        dd($users);
        return view('raport.form',compact('users'));
    }
    public function makeReport(Request $request)
    {
        $request->validate([
            'action'=>'required',
            'date1'=>'required',
            'date2'=>'required',
        ]);
        if (isset($request->action) && isset($request->date1) && isset($request->date2))
        {


            if ($request->action==="ALL")
            {
                $users = User::all();
                $allReabonnement=Reabonnement::join('formules','formules.id_formule','reabonnements.id_formule')->get();
                $allAbonnement = Abonnement::join('formules','formules.id_formule','abonnements.id_formule')->get();
                $allUpgrade = Upgrade::all();

                $decodeur = Decodeur::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->get()
                ;
                $decodeurs = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
                    ->get()
                ;
                $clientdecodeur = ClientDecodeur::all();
                $id_decodeur = [];
                foreach ($clientdecodeur as $key=> $value){
                    $id_decodeur[$key]=$value->id_decodeur;
                }
//        dd($id_decodeur);

                $decodeur = Decodeur::whereNotIn('decodeurs.id_decodeur',$id_decodeur)
                    ->get()
                ;
                $reabonnement = Reabonnement::join('formules','formules.id_formule','reabonnements.id_formule')
                    ->where('reabonnements.created_at','>=',$request->date1)
                    ->where('reabonnements.created_at','<=',$request->date2)
                    ->get()
                ;
                $abonnement = Abonnement::join('formules','formules.id_formule','abonnements.id_formule')
                    ->where('abonnements.created_at','>=',$request->date1)
                    ->where('abonnements.created_at','<=',$request->date2)
                    ->get()
                ;
                $upgrade = Upgrade::where('date_upgrade','>=',$request->date1)
                    ->where('date_upgrade','<=',$request->date2)
                    ->get()
                ;
                $recouvrement = Type_operation::where('date_ajout','>=',$request->date1)
                    ->where('date_ajout','<=',$request->date2)
                    ->get()
                ;
                $versement = Versement::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->get()
                ;
                $versement = Versement::all();
                $caisse = Caisse::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->get()
                ;
                $caisse = Caisse::all();

                $achatkit = Versement_achats::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->get()
                ;
                $TDATES = [];
                $TID = [];
                foreach ($abonnement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->date));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }

                }
                foreach ($reabonnement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->date));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }
                foreach ($upgrade as $key=>$value){

                    $date = $value->date_upgrade;
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }
                foreach ($versement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }
                foreach ($recouvrement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }
                foreach ($decodeur as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }

//                foreach ($users as $key=>$value){
//
//                }

                return view('raport.index',compact('request','users','TID','achatkit','TDATES','decodeur','reabonnement','abonnement',
                    'upgrade','recouvrement','versement','caisse','allReabonnement','allAbonnement','allUpgrade'));
            }else{
                $userid = $request->action;
                $user=User::find($userid);
                $decodeur = Decodeur::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $decodeurs = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
                    ->get()
                ;
                $clientdecodeur = ClientDecodeur::all();
                $id_decodeur = [];
                foreach ($clientdecodeur as $key=> $value){
                    $id_decodeur[$key]=$value->id_decodeur;
                }
//        dd($id_decodeur);

                $decodeur = Decodeur::whereNotIn('decodeurs.id_decodeur',$id_decodeur)
                    ->get()
                ;
                $reabonnement = Reabonnement::join('formules','formules.id_formule','reabonnements.id_formule')
                    ->where('reabonnements.created_at','>=',$request->date1)
                    ->where('reabonnements.created_at','<=',$request->date2)
                    ->select('reabonnements.*','reabonnements.created_at as date','formules.*')
                    ->where('reabonnements.id_user',$userid)
                    ->get()
                ;
                $abonnement = Abonnement::join('formules','formules.id_formule','abonnements.id_formule')
                    ->join('decodeurs','decodeurs.id_decodeur','abonnements.id_decodeur')
                    ->where('abonnements.created_at','>=',$request->date1)
                    ->where('abonnements.created_at','<=',$request->date2)
                    ->select('abonnements.*','abonnements.created_at as date','formules.*','decodeurs.*')
                    ->where('abonnements.id_user',$userid)
                    ->get()
                ;
                $upgrade = Upgrade::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $recouvrement = Type_operation::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $versement = Versement::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $caisse = Caisse::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $achatkit = Versement_achats::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $TDATES = [];
                foreach ($abonnement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->date));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($reabonnement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->date));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($upgrade as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($versement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($recouvrement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($decodeur as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($achatkit as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                return view('raport.forOne',compact('request','user','achatkit','decodeur','reabonnement','abonnement','upgrade','recouvrement','versement','caisse','TDATES'));

            }
            return 0;
        }else{
            return redirect()->back()->with('danger', 'Erreur! Mauvaise valeur entrée');
        }

    }

    public function print(Request $request)
    {
        $request->validate([
            'action'=>'required',
            'date1'=>'required',
            'date2'=>'required',
        ]);
        if (isset($request->action) && isset($request->date1) && isset($request->date2))
        {

            if ($request->action==="ALL")
            {
                $users = User::all();
                $allReabonnement=Reabonnement::join('formules','formules.id_formule','reabonnements.id_formule')->get();
                $allAbonnement = Abonnement::join('formules','formules.id_formule','abonnements.id_formule')->get();
                $allUpgrade = Upgrade::all();

                $decodeur = Decodeur::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->get()
                ;
                $decodeurs = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
                    ->get()
                ;
                $clientdecodeur = ClientDecodeur::all();
                $id_decodeur = [];
                foreach ($clientdecodeur as $key=> $value){
                    $id_decodeur[$key]=$value->id_decodeur;
                }
//        dd($id_decodeur);

                $decodeur = Decodeur::whereNotIn('decodeurs.id_decodeur',$id_decodeur)
                    ->get()
                ;
                $reabonnement = Reabonnement::join('formules','formules.id_formule','reabonnements.id_formule')
                    ->where('reabonnements.created_at','>=',$request->date1)
                    ->where('reabonnements.created_at','<=',$request->date2)
                    ->get()
                ;
                $abonnement = Abonnement::join('formules','formules.id_formule','abonnements.id_formule')
                    ->where('abonnements.created_at','>=',$request->date1)
                    ->where('abonnements.created_at','<=',$request->date2)
                    ->get()
                ;
                $upgrade = Upgrade::where('date_upgrade','>=',$request->date1)
                    ->where('date_upgrade','<=',$request->date2)
                    ->get()
                ;
                $recouvrement = Type_operation::where('date_ajout','>=',$request->date1)
                    ->where('date_ajout','<=',$request->date2)
                    ->get()
                ;
                $versement = Versement::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->get()
                ;
                $versement = Versement::all();
                $caisse = Caisse::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->get()
                ;
                $caisse = Caisse::all();

                $achatkit = Versement_achats::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->get()
                ;
                $TDATES = [];
                $TID = [];
                foreach ($abonnement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->date));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }

                }
                foreach ($reabonnement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->date));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }
                foreach ($upgrade as $key=>$value){

                    $date = $value->date_upgrade;
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }
                foreach ($versement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }
                foreach ($recouvrement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }
                foreach ($decodeur as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                    if (!in_array($value->id_user,$TID)){
                        $TID[count($TID)]= $value->id_user;
                    }
                }

//              PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')
                $pdf =  PDF::loadView('raport.printmany', compact('request','users','TID','achatkit','TDATES','decodeur','reabonnement','abonnement',
                    'upgrade','recouvrement','versement','caisse','allReabonnement','allAbonnement','allUpgrade','request'))
                    ->setPaper('a4', 'landscape')->setWarnings(false)
//                   ->save('rapport_'.$user->name.'_'.'de_'.$request->date1.'au'.$request->date2.'fait_le'.date('Y-m-d').'.pdf')
                ;
                return $pdf->download('rapport_'.'du_'.$request->date1.'au'.$request->date2.'fait_le'.date('Y-m-d').'.pdf');
//                return view('raport.printone',compact('user','achatkit','decodeur','reabonnement','abonnement','upgrade','recouvrement','versement','caisse','TDATES'));

//                return view('raport.printmany',compact('request','users','TID','achatkit','TDATES','decodeur','reabonnement','abonnement',
//                    'upgrade','recouvrement','versement','caisse','allReabonnement','allAbonnement','allUpgrade'));
            }else{
                $userid = $request->action;
                $user=User::find($userid);
                $decodeur = Decodeur::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $decodeurs = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
                    ->get()
                ;
                $clientdecodeur = ClientDecodeur::all();
                $id_decodeur = [];
                foreach ($clientdecodeur as $key=> $value){
                    $id_decodeur[$key]=$value->id_decodeur;
                }
//        dd($id_decodeur);

                $decodeur = Decodeur::whereNotIn('decodeurs.id_decodeur',$id_decodeur)
                    ->get()
                ;
                $reabonnement = Reabonnement::join('formules','formules.id_formule','reabonnements.id_formule')
                    ->where('reabonnements.created_at','>=',$request->date1)
                    ->where('reabonnements.created_at','<=',$request->date2)
                    ->select('reabonnements.*','reabonnements.created_at as date','formules.*')
                    ->where('reabonnements.id_user',$userid)
                    ->get()
                ;
                $abonnement = Abonnement::join('formules','formules.id_formule','abonnements.id_formule')
                    ->join('decodeurs','decodeurs.id_decodeur','abonnements.id_decodeur')
                    ->where('abonnements.created_at','>=',$request->date1)
                    ->where('abonnements.created_at','<=',$request->date2)
                    ->select('abonnements.*','abonnements.created_at as date','formules.*','decodeurs.*')
                    ->where('abonnements.id_user',$userid)
                    ->get()
                ;
                $upgrade = Upgrade::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $recouvrement = Type_operation::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $versement = Versement::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $caisse = Caisse::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $achatkit = Versement_achats::where('created_at','>=',$request->date1)
                    ->where('created_at','<=',$request->date2)
                    ->where('id_user',$userid)
                    ->get()
                ;
                $TDATES = [];
                foreach ($abonnement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->date));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($reabonnement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->date));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($upgrade as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($versement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($recouvrement as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($decodeur as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
                foreach ($achatkit as $key=>$value){

                    $date = date("Y-m-d", strtotime($value->created_at));
                    if (!in_array($date,$TDATES)){
                        $TDATES[count($TDATES)]= $date;
                    }
                }
//                PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')
                $pdf =  PDF::loadView('raport.printone', compact('user','achatkit','decodeur','reabonnement','abonnement','upgrade','recouvrement','versement','caisse','TDATES','request'))
                    ->setPaper('a4', 'landscape')->setWarnings(false)
//                   ->save('rapport_'.$user->name.'_'.'de_'.$request->date1.'au'.$request->date2.'fait_le'.date('Y-m-d').'.pdf')
                ;
                return $pdf->download('rapport_'.$user->name.'_'.'de_'.$request->date1.'au'.$request->date2.'fait_le'.date('Y-m-d').'.pdf');
//                return view('raport.printone',compact('user','achatkit','decodeur','reabonnement','abonnement','upgrade','recouvrement','versement','caisse','TDATES'));

            }
        }else{
            return redirect()->back()->with('danger', 'Erreur! Mauvaise valeur entrée');
        }

    }

    public function TodayOperations()
    {
        $data = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('formules', 'client_decodeurs.id_formule', 'formules.id_formule')
            ->join('clients', 'clients.id_client', 'client_decodeurs.id_client')
            ->where('client_decodeurs.date_abonnement', date('Y-m-d'))
            ->get()
        ;
        $date=date('Y-m-d');
        $abonnements = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
            ->join('clients', 'abonnements.id_client', 'clients.id_client')
            ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('users', 'abonnements.id_user', 'users.id')
            ->select('abonnements.duree as dureeabo','abonnements.*','clients.*','decodeurs.*','users.*','client_decodeurs.*','formules.*')
            ->where('abonnements.created_at','LIKE', "{$date}%")
            ->OrderBy('id_abonnement','DESC')
            ->get()
        ;
        $reabonnements = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->where('reabonnements.created_at', 'LIKE', "%{$date}%")
            ->join('users', 'reabonnements.id_user', 'users.id')
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get()
        ;
        $formules = Formule::all();
        $reabonnement = Reabonnement::join('clients', 'clients.id_client', 'reabonnements.id_client')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->get();
        $abonnement = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('clients', 'clients.id_client', 'clients.id_client')
            ->get();
        $upgrades = Upgrade::join('users', 'upgrades.id_user', 'users.id')
//            ->join('formules', 'formules.id_formule', 'upgrades.id_oldformule')
            ->where('upgrades.created_at', 'LIKE', "%{$date}%")
            ->OrderBy('id_upgrade', 'DESC')
            ->get()
        ;
        $formules = Formule::all();

        return view("operation_jour", compact('data','formules','abonnements','reabonnements','upgrades','formules','abonnement','reabonnement'));
    }

    public function OperationsCredit()
    {
        $data = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('formules', 'client_decodeurs.id_formule', 'formules.id_formule')
            ->join('clients', 'clients.id_client', 'client_decodeurs.id_client')
            ->where('client_decodeurs.date_abonnement', date('Y-m-d'))
            ->get()
        ;
        $date=date('Y-m-d');
        $abonnements = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
            ->join('clients', 'abonnements.id_client', 'clients.id_client')
            ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
            ->join('users', 'abonnements.id_user', 'users.id')
            ->select('abonnements.duree as dureeabo','abonnements.*','clients.*','decodeurs.*','users.*','client_decodeurs.*','formules.*')
            ->where('abonnements.type_abonnement', 0)
            ->OrderBy('id_abonnement','DESC')
            ->get()
        ;
        $reabonnements = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->where('reabonnements.type_reabonement', 0)
            ->join('users', 'reabonnements.id_user', 'users.id')
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get()
        ;
        $formules = Formule::all();
        $reabonnement = Reabonnement::join('clients', 'clients.id_client', 'reabonnements.id_client')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->get();
        $abonnement = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('clients', 'clients.id_client', 'clients.id_client')
            ->get();
        $upgrades = Upgrade::join('users', 'upgrades.id_user', 'users.id')
            ->where('upgrades.type_upgrade', 0)
            ->OrderBy('id_upgrade', 'DESC')
            ->get()
        ;
        $formules = Formule::all();

        return view("operation-credit", compact('data','abonnements','reabonnements','upgrades','formules','abonnement','reabonnement'));
    }

    public function CalculTotalCredit()
    {

        $abonnements = Abonnement::join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
            ->where('abonnements.type_abonnement', 0)
            ->get()
        ;
        $reabonnements = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->where('reabonnements.type_reabonement', 0)
            ->get()
        ;

        $upgrades = Upgrade::join('users', 'upgrades.id_user', 'users.id')
            ->where('upgrades.type_upgrade', 0)
            ->get()
        ;
        $totalabo= 0;
        $totalreabo = 0;
        $totalup = 0;
        $total = 0;
        foreach ($reabonnements as $key=>$value)
        {
            $totalreabo += $value->prix_formule * $value->duree ;
        }
        foreach ($abonnements as $key=>$value)
        {
            $totalabo += $value->prix_formule * $value->duree + $value->prix_decodeur;
        }
//        dd($totalabo,$totalreabo);
        foreach ($upgrades as $key=>$value)
        {
            $totalup += $value->montant_upgrade;
        }

        $total = $totalabo + $totalreabo + $totalup;
        return $total;

    }



}
//set_time_limit(300);
