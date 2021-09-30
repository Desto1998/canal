<?php

namespace App\Http\Controllers;

use App\Models\Reabonnement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SortController extends Controller
{
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
                        ->where('reabonnements.created_at', '<=', $request->date2)
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
                        ->where('reabonnements.date_reabonnement', '<=', $request->date2)
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
                        ->where('client_decodeurs.date_reabonnement', '<=', $request->date2)
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
}
