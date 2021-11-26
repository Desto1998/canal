<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDecodeur;
use App\Models\Decodeur;
use App\Models\Formule;
use App\Models\Reabonnement;
use App\Models\Stock;
use App\Models\Upgrade;
use App\Models\Vente_materiel;
use http\Client\Curl\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;

class StockController extends Controller
{
    //
    public function makeForm(Request $request)
    {
        $request->validate([
            'quantite'=>'required|numeric|min:1|',
            'prix_u'=>'required|numeric',
            'date_appro'=>'required'
        ]);
        return view('stocks.Addmultiple',compact('request'));
    }
    public function storeDecodeur(Request $request)
    {
        $id_user = Auth::user()->id;
        $request->validate([
            'quantite'=>'required|numeric|min:1',
            'code_stock'=>'required',
            'prix_u'=>'required|numeric',
            'date_appro'=>'required'
        ]);
        $done =0;
        $fail = 0;
        $stock=[];
        foreach ($request->code_stock as $num=> $item)
        {
            $check  = Stock::where('code_stock',$item)
                ->get();
            if (!isset($check[0])){
                $done++;
                $stock[$num] = Stock::create([
                    'code_stock'=>$item,
                    'prix_unit'=>$request->prix_u,
//                    'date_appro'=>$request->date_appro,
                    'date_ajout'=>date('Y-m-d'),
                    'id_user'=>$id_user,
                    'statut'=>0
                ]);
            }else{
                $fail ++;
            }
            $nombre = count($stock);
            $raison = "Enrgistrement de $nombre decodeur(s). prix unit de $request->prix_u, approvisionné le $request->date_appro";
            $debitcaisse = (new CaisseController)->debitCaisse(-$request->prix_u * $nombre,$raison);
        }
        if ($fail==0)
        {
            return  redirect(route('stock'))->with('info', 'Les enregistrements ont été effectué avec succès.');

        }else{
            return  redirect(route('stock'))->with('warning', $done.' enregistrements ont été effectué avec succès. Certains existent dejà dans le système.');

        }
    }
    public function deleteDecodeur(Request $request)
    {
        $get = Stock::where('id_stock',$request->id)->get();
        $del = Stock::where('id_stock',$request->id)->delete();
        $montant = $get[0]->prix_unit;
        $raison = 'Suppression du materiel en stock';
        $debitcaisse = (new CaisseController)->debitCaisse($montant,$raison);
        return Response()->json($del);
    }

    public function addVente(Request $request)
    {
        $request->validate([
            'id_stock' => 'required',
        ]);
        $userid = Auth::user()->id;
        $data = new Array_();
//        $data->duree = $request->duree;
//        $date_reabonnement = date_format(date_add(date_create("$request->date_reabonnement"), date_interval_create_from_date_string("$request->duree months")), 'Y-m-d');
//
//
//        $date = new DateTime($date_reabonnement);
//        $date->sub(new DateInterval("P{$request->duree}D"));
//        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
//        $data->date_reabonnement = $date;
//        $date_reabonnement = $data->date_reabonnement;
//        $data->duree = $request->duree;

//        $data->date_abonnement = $request->date_abonnement;
//        $oldformule = Formule::where('id_formule', $request->oldformule)->get();
//        $newformule = Formule::where('id_formule', $request->newformule)->get();
//        if (isset($oldformule[0]) && isset($newformule[0])){
//            $montant_upgrade = $newformule[0]->prix_formule - $oldformule[0]->prix_formule;
//        }
        $materiel = Stock::where('id_stock',$request->id_stock)->get();
        if (isset($request->check) && $request->check==1)
        {
//            dd($request);
            $request->validate([
                'id_client' => 'required',
            ]);

            $id_client = $request->id_client;
            $client = Client::where('id_client',$request->id_client)->get();
            $decodeur = Decodeur::where('num_decodeur',$materiel[0]->code_stock)->get();

//            $clientdecodeur = ClientDecodeur::where('id_decodeur',$request->id_decodeur)->get();
            if (isset($decodeur[0])){
                return redirect()->back()->with('danger','LE décodeur est déja utilisé par un autre client.');
            }

            $data->nom_client = $client[0]->nom_client;
            $data->prenom_client = $client[0]->prenom_client;
            $data->num_abonne = $request->num_abonne;
            $data->telephone_client = $client[0]->telephone_client;
            $data->num_decodeur = $materiel[0]->code_stock;
            $decora = Decodeur::create([
                'num_decodeur' => $data->num_decodeur,
                'prix_decodeur' => $request->prix_vente,
                'date_livaison' => $materiel[0]->date_ajout,
                'quantite' => 1,
                'id_user' => $userid
            ]);
            $CD = ClientDecodeur::create(['id_decodeur' => $decora->id,
                'id_client' => $client[0]->id_client,
                'id_user' => $userid,
                'date_abonnement' => date('Y-m-d'),
                'date_reabonnement' => date('Y-m-d'),
                'id_formule' => 1,
                'num_abonne' => $request->num_abonne,
            ]);
            $data->id_materiel = $decora->id;
            $data->id_materiel = $request->id_decodeur;

        }else{
            $request->validate([
                'num_abonne' => 'required',
                'telephone_client' => 'required',
                'nom_client' => 'required',
            ]);
            $checkclient = Client::where('telephone_client',$request->telephone_client)->get();

//            dd($checkclient, $request);
            if (count($checkclient)>0)
            {
                return redirect()->back()->with('danger', 'Le client existe déja! Veillez sélectionner ou utiliser un autre numéro de télephone.');
            }

            $data->nom_client = $request->nom_client;
            $data->prenom_client = $request->prenom_client;
            $data->adresse_client = $request->adresse_client;
            $data->num_abonne = $request->num_abonne;
            $data->telephone_client = $request->telephone_client;
            $data->id_user = $userid;
            $data->num_decodeur = $materiel[0]->code_stock;
            $decora = Decodeur::create([
                'num_decodeur' => $data->num_decodeur,
                'prix_decodeur' => $request->prix_vente,
                'date_livaison' => $materiel[0]->date_ajout,
                'quantite' => 1,
                'id_user' => $userid
            ]);
            $data->id_materiel = $decora->id;
            $client = Client::create([
                'nom_client' => $data->nom_client,
                'prenom_client' => $data->prenom_client,
                'adresse_client' => $data->adresse_client,
                'duree' => 0,
                'id_materiel' => $data->id_materiel,
                'date_abonnement' =>date('Y-m-d'),
                'date_reabonnement' => date('Y-m-d'),
                'id_user' => $userid,
                'telephone_client' => $data->telephone_client
            ]);

            $CD = ClientDecodeur::create(['id_decodeur' => $decora->id,
                'id_client' => $client->id_client,
                'id_user' => $userid,
                'date_abonnement' => date('Y-m-d'),
                'date_reabonnement' => date('Y-m-d'),
                'id_formule' =>1,
                'num_abonne' => $data->num_abonne,
            ]);
            $id_client = $client->id_client;
        }
        $changestatus = Stock::where('id_stock',$request->id_stock)
            ->update(['statut'=>1]);
        $vente = Vente_materiel::create(
            [
              'montant_vente'=>$request->prix_vente,
                'tpyre_vente'=>1,
                'date_vente'=>date('Y-m-d'),
                'id_stock'=>$request->id_stock,
                'id_user'=>$userid,
                'id_client'=>$id_client
            ]
        );

//        $statut = 0;
//        if ($request->type == 1) {
//            $statut = 1;
//        }

//        $reabonnement = Reabonnement::create(['id_decodeur' => $data->id_materiel,
//            'id_client' => $id_client,
//            'id_formule' => 0,
//            'id_user' => $userid,
//            'type_reabonement' => $request->type,
//            'statut_reabo' => $statut,
//            'duree' => $data->duree,
//            'date_echeance' => $date_reabonnement,
//            'date_reabonnement' => $request->date_reabonnement
//        ]);


        $data_pdf = new Array_();
        $data_pdf->prix_materiel = $request->prix_vente;
        $data_pdf->nb_materiel = 1;
        $data_pdf->nom_client = $data->nom_client;
        $data_pdf->prenom_client = $data->prenom_client;
        $data_pdf->num_abonne = $data->num_abonne;
        $data_pdf->telephone_client = $data->telephone_client;
        $data_pdf->dureeA = 0;
        $data_pdf->dureeR = 0;
        $data_pdf->dureeU = 0;
//        $data_pdf->dureeU = $data->duree;
        $data_pdf->num_decodeur = $data->num_decodeur;
        $data_pdf->nom_formule = '';
        $data_pdf->prix_formuleU = 0;
        $data_pdf->prix_formuleR = 0;
        $data_pdf->prix_formuleA = 0;
        $data_pdf->total = $request->prix_vente;
        $data_pdf->date_reabonnement = '';
        $data_pdf->date_abonnement = '';

        $data_message = new Array_();
        $data_message->nom = $data->nom_client;
        $data_message->prenom = $data->prenom_client;
        $data_message->phone = $data->telephone_client;
        $data_message->datereabo ='';
        $data_message->dateecheance = '';
        $data_message->montant = $request->prix_vente;
        $data_message->id_client = $id_client;

        if ($vente) {
            $storeCaisse = (new CaisseController)->creditCaisse($materiel[0]->id_stock, 'DECODEUR', $data_pdf->total);
            if (isset($request->printpdf) && $request->printpdf == 1) {

                (new PDFController)->createPDF($data_pdf, 'UPGRADE');
            }
            return redirect()->back()->with('info', "Vente enregistré avec succès! ");
        }
//        if (isset($request->sendsms) && $request->sendsms == 1) {
//            $envoi = (new MessageController)->prepareMessage($data_message, 'REABONNEMENT');
//        }

        $balance = (new MessageController)->getSMSBalance();
        session()->flash('message', "Echec d'enregistrement de la vente! ");
        return redirect()->back()->with('info', "Echec d'enregistrement de la vente! ");

    }
    public function deleteVente(Request $request)
    {
        $get=Vente_materiel::where('id_vente',$request->id)->get();
        $remove = Vente_materiel::where('id_vente',$request->id)->delete();
        if ($remove){
            $montant = $get[0]->montant_vente;
            $raison = "Suppression d'une vente de materiel.";
            $debitcaisse = (new CaisseController)->debitCaisse(-$montant,$raison);

        }
        return Response()->json($remove);
    }
}
