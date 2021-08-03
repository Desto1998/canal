<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class PDFController extends Controller
{
    private $fpdf;

    public function __construct()
    {

    }
    public function createPDF($data)
    {
        $this->fpdf = new Fpdf;
        //Header
        $this->fpdf->AddPage("L", ['189', '219']);
        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Image('C:\Users\chatr\Downloads\Documents\canal\public\images\logo\jpg_logo.jpg',10,6,50);
        $this->fpdf->Cell(60);
        $this->fpdf->Cell(50,15,'RECU DE CAISSE',0,0,'C');
        $this->fpdf->Cell(30);
        $this->fpdf->Image('C:\Users\chatr\Downloads\Documents\canal\public\images\logo\CANAL2.JPG',null,null,50);

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
        $this->fpdf->Cell(32,5,'Nom et prenom:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(70,5,'$data->nom_client $data->nom_client',0,0);
        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(22,5,'Telephone:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(34,5,'[Num_telephone]',0,1);//Fin de ligne
        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(25,5,'N Abonne:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(105,5,'[98745632]',0,0);
        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(47,5,"Module d'activation:",0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(47,5,'CGA',0,1);


        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(25,5,'N Decodeur:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(46,5,'[98745632012345]',0,1);

        $this->fpdf->SetFont("Arial",'B',12);
        $this->fpdf->Cell(25,5,'Formule:',0,0);
        $this->fpdf->SetFont("Times",'',12);
        $this->fpdf->Cell(34,5,'[formule]',0,1);//Fin de ligne
        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->SetFont('Arial','B',12);

        $this->fpdf->Cell(130,5,'Designation',1,0);
        $this->fpdf->Cell(25,5,'Duree',1,0);
        $this->fpdf->Cell(34,5,'Montant',1,1);//Fin de ligne

        $this->fpdf->SetFont('Arial','',12);

        $this->fpdf->Cell(130,5,'[Action]',1,0);
        $this->fpdf->Cell(25,5,'1',1,0);
        $this->fpdf->Cell(34,5,'10000',1,1);//Fin de ligne

        $this->fpdf->Cell(130,5,'[Action]',1,0);
        $this->fpdf->Cell(25,5,'6',1,0);
        $this->fpdf->Cell(34,5,'150000',1,1);//Fin de ligne

        $this->fpdf->Cell(130,5,'[Action]',1,0);
        $this->fpdf->Cell(25,5,'3',1,0);
        $this->fpdf->Cell(34,5,'75500',1,1);//Fin de ligne
        //Total
        $this->fpdf->Cell(130,5,'',1,0);
        $this->fpdf->Cell(25,5,'Total',1,0);
        $this->fpdf->Cell(34,5,'175500',1,1,'R');//Fin de ligne

        $this->fpdf->Cell(189,5,'',0,1);

        $this->fpdf->Cell(189,5,'Arrete le present recu a la somme de :',0,1);
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
        $this->fpdf->Cell(47,5,"[Nom du client]",0,1);
        $this->fpdf->Cell(189,5,'',0,1);
        $this->fpdf->SetFont("Times",'',9);
        $this->fpdf->Cell(95,5,'Important : Notre service apres vente reste a votre disposition.',0,1);
        $this->fpdf->Cell(95,5,"En cas de probleme contacter nous au telephone: 651902626 ou email:info@getelcameroun.com",0,1);


        $this->fpdf->Output();
        exit;
    }

}
