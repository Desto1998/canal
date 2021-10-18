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
            ->get();
        $reabonnement = Reabonnement::all();
        return view("upgrade.upgrader", compact('data', 'reabonnement', 'clientdecodeur'));
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
        }

        return Response()->json($upgrade);
    }
}
