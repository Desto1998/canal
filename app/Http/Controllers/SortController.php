<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Caisse;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Reabonnement;
use App\Models\User;
use App\Models\Versement;
use App\Models\Versement_achats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SortController extends Controller
{
    //sort caisse
    public function sortByCaisse(Request $request){
//        dd($request);
        if (isset( $request->date1 ) && isset($request->date2) ){

            $totalcaisse = Caisse::where('created_at','>=',$request->date1)
                ->where('created_at','<=',$request->date2)
                ->sum("montant")
            ;

            $versements = Versement::where('created_at','>=',$request->date1)
                ->where('created_at','<=',$request->date2)
                ->OrderBy('id_versement','DESC')
                ->get()
            ;
            $achats = Versement_achats::where('created_at','>=',$request->date1)
                ->where('created_at','<=',$request->date2)
                ->OrderBy('id_achat','DESC')
                ->get()
            ;
            $Caisse = Caisse::join('users','users.id','caisses.id_user')
                ->where('caisses.date_ajout','>=',$request->date1)
                ->where('caisses.date_ajout','<=',$request->date2)
                ->OrderBy('id_caisse','DESC')
                ->get();

            $totalVersement = Versement::where('created_at','>=',$request->date1)
                ->where('created_at','<=',$request->date2)
                ->sum("montant_versement")
            ;

            $dejaUTilise = Formule::join('reabonnements','formules.id_formule','reabonnements.id_formule')
                ->where('reabonnements.created_at','>=',$request->date1)
                ->where('reabonnements.created_at','<=',$request->date2)
                ->sum(\DB::raw('formules.prix_formule * reabonnements.duree'))
            ;
            $resteVersement = $totalVersement - $dejaUTilise;
            $users = Versement::join('users','users.id','versements.id_user')->get();
            return view('caisse',compact('Caisse','users','totalVersement','resteVersement','dejaUTilise',
                'totalcaisse','versements','achats'));
        }

        if (isset( $request->date1 )){
            $totalcaisse = Caisse::where('created_at','>=',$request->date1)
                ->sum("montant")
            ;

            $versements = Versement::where('created_at','>=',$request->date1)
                ->OrderBy('id_versement','DESC')
                ->get()
            ;
            $achats = Versement_achats::where('created_at','>=',$request->date1)
                ->OrderBy('id_achat','DESC')
                ->get()
            ;
            $Caisse = Caisse::join('users','users.id','caisses.id_user')
                ->where('caisses.date_ajout','>=',$request->date1)
                ->OrderBy('id_caisse','DESC')
                ->get();

            $totalVersement = Versement::where('created_at','>=',$request->date1)
                ->sum("montant_versement")
            ;

            $dejaUTilise = Formule::join('reabonnements','formules.id_formule','reabonnements.id_formule')
                ->where('reabonnements.created_at','>=',$request->date1)
                ->sum(\DB::raw('formules.prix_formule * reabonnements.duree'))
            ;
            $resteVersement = $totalVersement - $dejaUTilise;
            $users = Versement::join('users','users.id','versements.id_user')->get();
            return view('caisse',compact('Caisse','users','totalVersement','resteVersement','dejaUTilise',
                'totalcaisse','versements','achats'));
        }

        if (isset( $request->date2 )){
            $totalcaisse = Caisse::where('created_at','<=',$request->date2)
                ->sum("montant")
            ;

            $versements = Versement::where('created_at','<=',$request->date2)
                ->OrderBy('id_versement','DESC')
                ->get()
            ;
            $achats = Versement_achats::where('created_at','<=',$request->date2)
                ->OrderBy('id_achat','DESC')
                ->get()
            ;
            $Caisse = Caisse::join('users','users.id','caisses.id_user')
                ->where('caisses.date_ajout','<=',$request->date2)
                ->OrderBy('id_caisse','DESC')
                ->get();

            $totalVersement = Versement::where('created_at','<=',$request->date2)
                ->sum("montant_versement")
            ;

            $dejaUTilise = Formule::join('reabonnements','formules.id_formule','reabonnements.id_formule')
                ->where('reabonnements.created_at','<=',$request->date2)
                ->sum(\DB::raw('formules.prix_formule * reabonnements.duree'))
            ;
            $resteVersement = $totalVersement - $dejaUTilise;
            $users = Versement::join('users','users.id','versements.id_user')->get();
            return view('caisse',compact('Caisse','users','totalVersement','resteVersement','dejaUTilise',
                'totalcaisse','versements','achats'));
        }
    }
    //
    public function sortReabonnement(Request $request)
    {
//        return $request;
        $userid = Auth::user()->id;
        if (isset($request->byUser) && isset($request->byDate) && isset($request->date1) && isset($request->date2)) {
            if ($request->byUser === 'ALL') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '>=', $request->date1)
                        ->where('reabonnements.date_reabonnement', '<=', $request->date2)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '>=', $request->date1)
                        ->where('client_decodeurs.date_reabonnement', '<=', $request->date2)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
            }

            if ($request->byUser === 'BYME') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '>=', $request->date1)
                        ->where('reabonnements.date_reabonnement', '<=', $request->date2)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '>=', $request->date1)
                        ->where('client_decodeurs.date_reabonnement', '<=', $request->date2)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));
                }
            }

            if ($request->byUser === 'BYORTHERS') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '>=', $request->date1)
                        ->where('reabonnements.date_reabonnement', '<=', $request->date2)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '>=', $request->date1)
                        ->where('client_decodeurs.date_reabonnement', '<=', $request->date2)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));
                }
            }

        }


        if (isset($request->byUser) && isset($request->byDate) && isset($request->date1)) {
            if ($request->byUser === 'ALL') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '>=', $request->date1)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '>=', $request->date1)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '>=', $request->date1)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
            }
            //Par moi BYME
            if ($request->byUser === 'BYME') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '>=', $request->date1)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.created_at', '<=', $request->date2)->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '>=', $request->date1)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));
                }
            }

            if ($request->byUser === 'BYORTHERS') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '>=', $request->date1)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '>=', $request->date1)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '>=', $request->date1)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));
                }
            }

        }


        if (isset($request->byUser) && isset($request->byDate) && isset($request->date2)) {
            // tous les staatuts
            if ($request->byUser === 'ALL') {
                //date creation
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '<=', $request->date2)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                // Date reabo
                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '<=', $request->date2)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                // date echeance
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '<=', $request->date2)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
            }
            // par moi BYME
            if ($request->byUser === 'BYME') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '<=', $request->date2)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '<=', $request->date2)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                       ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '<=', $request->date2)
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));
                }
            }
            // par les autres OTHERS
            if ($request->byUser === 'BYORTHERS') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.created_at', '<=', $request->date2)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.date_reabonnement', '<=', $request->date2)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('client_decodeurs.date_reabonnement', '<=', $request->date2)
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::where('reabonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));
                }
            }

        }

        if (isset($request->byUser) && isset($request->byDate)) {
            if ($request->byUser === 'ALL') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
            }

            if ($request->byUser === 'BYME') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    return view("users.allreabonnement", compact('data', 'reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.id_user', $userid)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));
                }
            }

            if ($request->byUser === 'BYORTHERS') {
                if ($request->byDate === 'CREATE') {
                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('reabonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }

                if ($request->byDate === 'START') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('reabonnements.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));

                }
                if ($request->byDate === 'STOP') {

                    $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
                        ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
                        ->where('reabonnements.id_user','!=', $userid)
                        ->OrderBy('client_decodeurs.date_reabonnement', 'ASC')
                        ->get()
                    ;
                    $reabonnement = Reabonnement::all();
                    $users = User::all();
                    return view("users.allreabonnement", compact('data','users','reabonnement'));
                }
            }

        }
//        dd($request);
        $data = Reabonnement::join('clients', 'reabonnements.id_client', 'clients.id_client')
            ->join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->join('client_decodeurs', 'client_decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->OrderBy('reabonnements.id_reabonnement', 'DESC')
            ->get()
        ;
        $reabonnement = Reabonnement::all();
        $users = User::all();
        return view("users.allreabonnement", compact('data','users','reabonnement'));

    }

    public function sortAbonnement(Request $request)
    {
//        return $request;
        $userid = Auth::user()->id;
        if (isset($request->byUser) && isset($request->byDate) && isset($request->date1) && isset($request->date2)) {
            if ($request->byUser === 'ALL') {
                if ($request->byDate === 'CREATE') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }

                if ($request->byDate === 'START') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
            }

            if ($request->byUser === 'BYME') {
                if ($request->byDate === 'CREATE') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
            }

            if ($request->byUser === 'BYORTHERS') {
                if ($request->byDate === 'CREATE') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.created_at', '<=', $request->date2)->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
            }

        }


        if (isset($request->byUser) && isset($request->byDate) && isset($request->date1)) {
            if ($request->byUser === 'ALL') {
                if ($request->byDate === 'CREATE') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
            }
            //Par moi BYME
            if ($request->byUser === 'BYME') {
                if ($request->byDate === 'CREATE') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
            }

            if ($request->byUser === 'BYORTHERS') {
                if ($request->byDate === 'CREATE') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '>=', $request->date1)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '>=', $request->date1)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date1)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
            }

        }


        if (isset($request->byUser) && isset($request->byDate) && isset($request->date2)) {
            // tous les staatuts
            if ($request->byUser === 'ALL') {
                if ($request->byDate === 'CREATE') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '>=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
            }
            //Par moi BYME
            if ($request->byUser === 'BYME') {
                if ($request->byDate === 'CREATE') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
            }

            if ($request->byUser === 'BYORTHERS') {
                if ($request->byDate === 'CREATE') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->where('client_decodeurs.created_at', '<=', $request->date2)->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.created_at', '<=', $request->date2)
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::where('abonnements.created_at', '<=', $request->date2)
                        ->get()
                    ;
                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
            }


        }

        if (isset($request->byUser) && isset($request->byDate)) {
            if ($request->byUser === 'ALL') {
                if ($request->byDate === 'CREATE') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
            }

            if ($request->byUser === 'BYME') {
                if ($request->byDate === 'CREATE') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.id_user', $userid)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));

                }
            }

            if ($request->byUser === 'BYORTHERS') {
                if ($request->byDate === 'CREATE') {
                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.created_at', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }

                if ($request->byDate === 'START') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.date_reabonnement', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


                }
                if ($request->byDate === 'STOP') {

                    $clientdecodeur = Decodeur::join('client_decodeurs', 'decodeurs.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->get()
                    ;
                    $data = Abonnement::join('clients', 'abonnements.id_client', 'clients.id_client')
                        ->join('formules', 'abonnements.id_formule', 'formules.id_formule')
                        ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
                        ->join('client_decodeurs', 'abonnements.id_decodeur', 'client_decodeurs.id_decodeur')
                        ->select('abonnements.date_reabonnement as date_debut', 'decodeurs.num_decodeur',
                            'decodeurs.prix_decodeur', 'abonnements.*', 'formules.*', 'clients.*', 'client_decodeurs.num_abonne'
                        )
                        ->where('abonnements.id_user','!=', $userid)
                        ->OrderBy('abonnements.date_echeance', 'DESC')
                        ->get()
                    ;
                    $decodeur = Decodeur::all();
                    $users = User::all();
                    $reabonnement = Abonnement::all();

                    return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));
                }
            }

        }

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
        $decodeur = Decodeur::all();
        $users = User::all();
        $reabonnement = Abonnement::all();
        return view("abonnement.abonner", compact('decodeur','data', 'users', 'reabonnement', 'clientdecodeur'));


    }
}
