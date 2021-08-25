<?php

namespace App\Http\Controllers;

use App\Models\Decodeur;
use App\Models\Formule;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class PDFController extends Controller
{
    private $fpdf;

    public function __construct()
    {

    }
    public function createPDF($data,$action)
    {
        $this->fpdf = new Fpdf;
        //Header
        $this->fpdf->AddPage("L", ['189', '219']);
        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Image("http://127.0.0.1:8000/images/logo/logo_getel.jpg",10,6,50,0,'jpg');
//        $this->fpdf->Image("{{ asset('images/logo/logo_getel.jpg) }}",10,6,50,0,'jpg');
        $this->fpdf->Cell(60);
        $this->fpdf->Cell(50,15,'RECU DE CAISSE',0,0,'C');
        $this->fpdf->Cell(30);
        $this->fpdf->Image("http://127.0.0.1:8000/images/logo/logo_canal.jpg",null,null,50,0,'jpg');
//        $this->fpdf->Image("{{ asset('images/logo/logo_canal.jpg) }}",null,null,50,0,'jpg');

        $this->fpdf->SetFont("Arial",'',8);
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(130,5,'RCCM:DLA/2018/2016/B/1825',0,0);
        $this->fpdf->Cell(59,5,'',0,1);//Fin de ligne

        $this->fpdf->Cell(130,5,'No Contribuable:MO51812705675P',0,0);
        $this->fpdf->Cell(59,5,'',0,1);//Fin de ligne

        $this->fpdf->SetFont("Arial",'',12);
        $this->fpdf->Cell(130,5,'Adresse: Andem-Logpom',0,0);
        $this->fpdf->Cell(20,5,'Date:',0,0);
        $this->fpdf->Cell(39,5,now(),0,1);//Fin de ligne
        $this->fpdf->Ln(5);

        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(34,5,'Nom et prenom:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(70,5,$data->nom_client." ".$data->prenom_client,0,0);
        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(24,5,'Telephone:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(34,5,$data->telephone_client,0,1);//Fin de ligne
        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(25,5,'N Abonne:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(105,5,$data->num_abonne,0,0);
        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(47,5,"Module d'activation:",0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(47,5,'CGA',0,1);


            $this->fpdf->SetFont("Arial", 'B', 12);
            $this->fpdf->Cell(25, 5, 'N Decodeur:', 0, 0);
            $this->fpdf->SetFont("Times", '', 12);
            $this->fpdf->Cell(160, 5, $data->num_decodeur, 0, 1);


        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(25,5,'Formule:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(34,5,$data->nom_formule,0,1);//Fin de ligne
        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->SetFont('Arial','B',12);

        $this->fpdf->Cell(130,5,'Designation',1,0);
        $this->fpdf->Cell(25,5,'Duree',1,0);
        $this->fpdf->Cell(34,5,'Montant',1,1);//Fin de ligne

        $this->fpdf->SetFont('Arial','',12);


            $this->fpdf->SetFont("Arial",'B',12);
            $this->fpdf->Cell(130,5,'Abonnement',1,0);
            $this->fpdf->Cell(25,5,$data->duree,1,0);
            $this->fpdf->Cell(34,5,"{$data->duree} * {$data->prix_formuleA}",1,1);//Fin de ligne


            $this->fpdf->Cell(130, 5, 'Reabonnement', 1, 0);
            $this->fpdf->Cell(25, 5, $data->duree, 1, 0);
            $this->fpdf->Cell(34, 5, "{$data->duree} * {$data->prix_formuleR}", 1, 1);//Fin de ligne

            $this->fpdf->Cell(130, 5, 'Upgrade', 1, 0);
            $this->fpdf->Cell(25, 5, "1", 1, 0);
//            $this->fpdf->Cell(34, 5, $data->difference, 1, 1);//Fin de ligne
            $this->fpdf->Cell(34, 5, $data->prix_formuleU, 1, 1);//Fin de ligne

        //Total
        $this->fpdf->Cell(130,5,'',0,0);
        $this->fpdf->Cell(25,5,'Total',0,0);
        $this->fpdf->Cell(34,5,$data->total,1,1,'R');//Fin de ligne

        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->Cell(189,5,'Arrete le present recu a la somme de : '.$data->total.' FCFA',0,1);
        $this->fpdf->Line(195,125,10,125);
        $this->fpdf->Cell(189,5,'',0,1);
        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->SetFont("Arial",'',12);
        $this->fpdf->Cell(137,5,'Noms et signature du vendeur',0,0);
        $this->fpdf->Cell(47,5,"Noms et signature du client",0,1);
        $this->fpdf->Cell(189,5,'',0,1);
        $this->fpdf->Cell(189,5,'',0,1);
        $this->fpdf->Cell(189,5,'',0,1);
        $this->fpdf->Cell(140,5,'GETEL SARL',0,0);
        $this->fpdf->Cell(47,5,$data->nom_client." ".$data->prenom_client,0,1);
        $this->fpdf->Cell(189,5,'',0,1);
        $this->fpdf->SetFont("Times",'',9);
        $this->fpdf->Cell(95,5,'Important : Notre service apres vente reste a votre disposition.',0,1);
        $this->fpdf->Cell(95,5,"En cas de probleme contacter nous au telephone: 651902626 ou email:info@getelcameroun.com",0,1);


        $this->fpdf->Output();
        exit;
    }

}
