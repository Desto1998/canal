<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Decodeur;
use App\Models\Reabonnement;
use App\Models\Client;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\AbstractList;
use phpDocumentor\Reflection\Types\Array_;

class FactureController extends Controller
{
    //
    public function printFactureReabo($id)
    {

        $reabonnement = Reabonnement::join('formules', 'reabonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'reabonnements.id_decodeur')
            ->where('reabonnements.id_reabonnement', $id)
            ->get();
        $client = Client::find($reabonnement[0]->id_client);
        $decodeur = Decodeur::where('id_decodeur', $reabonnement[0]->id_decodeur)->get();
        $decos = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
            ->where('client_decodeurs.id_decodeur', $reabonnement[0]->id_decodeur)
            ->get();

        $data_pdf = new Array_();
        $data_pdf->prix_formuleA = 0;
        $data_pdf->prix_formuleR = $reabonnement[0]->prix_formule;
        $data_pdf->prix_formuleU = 0;
        $data_pdf->dureeA = 0;
        $data_pdf->dureeR = $reabonnement[0]->duree;
        $data_pdf->dureeU = 0;

        $data_pdf->prix_materiel = 0;
        $data_pdf->nb_materiel = 0;
        $data_pdf->nom_client = $client->nom_client;
        $data_pdf->prenom_client = $client->prenom_client;
        $data_pdf->num_abonne = $decos[0]->num_abonne;
        $data_pdf->telephone_client = $client->telephone_client;

        $data_pdf->num_decodeur = $decodeur[0]->num_decodeur;
        $data_pdf->nom_formule = $reabonnement[0]->nom_formule;

        $data_pdf->total = $reabonnement[0]->duree * $reabonnement[0]->prix_formule;
        $data_pdf->date_reabonnement = $reabonnement[0]->date_echeance;
        $data_pdf->date_abonnement = $reabonnement[0]->date_reabonnement;
        $print = (new PDFController)->createPDF($data_pdf, 'PRINTPDF');
    }

    public function printFactureAbo($id)
    {

        $reabonnement = Abonnement::join('formules', 'abonnements.id_formule', 'formules.id_formule')
            ->join('decodeurs', 'decodeurs.id_decodeur', 'abonnements.id_decodeur')
            ->where('abonnements.id_abonnement', $id)
            ->get();
        $client = Client::find($reabonnement[0]->id_client);
        $decodeur = Decodeur::where('id_decodeur', $reabonnement[0]->id_decodeur)->get();
        $decos = Decodeur::join('client_decodeurs', 'client_decodeurs.id_decodeur', 'decodeurs.id_decodeur')
            ->where('client_decodeurs.id_decodeur', $reabonnement[0]->id_decodeur)
            ->get();

        $data_pdf = new Array_();

        $data_pdf->prix_formuleA = $reabonnement[0]->prix_formule;
        $data_pdf->prix_formuleR = 0;
        $data_pdf->prix_formuleU = 0;
        $data_pdf->dureeA = $reabonnement[0]->duree;
        $data_pdf->dureeR = 0;
        $data_pdf->dureeU = 0;

        $data_pdf->prix_materiel = 0;
        $data_pdf->nb_materiel = 0;
        $data_pdf->nom_client = $client->nom_client;
        $data_pdf->prenom_client = $client->prenom_client;
        $data_pdf->num_abonne = $decos[0]->num_abonne;
        $data_pdf->telephone_client = $client->telephone_client;

        $data_pdf->num_decodeur = $decodeur[0]->num_decodeur;
        $data_pdf->nom_formule = $reabonnement[0]->nom_formule;

        $data_pdf->total = $reabonnement[0]->duree * $reabonnement[0]->prix_formule;
        $data_pdf->date_reabonnement = $reabonnement[0]->date_echeance;
        $data_pdf->date_abonnement = $reabonnement[0]->date_reabonnement;
        $print = (new PDFController)->createPDF($data_pdf, 'PRINTPDF');
    }
}
