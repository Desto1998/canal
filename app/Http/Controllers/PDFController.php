<?php

namespace App\Http\Controllers;

use App\Models\Decodeur;
use App\Models\Formule;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    private $fpdf;

    public function __construct()
    {

    }

    public function createPDF($data, $action)
    {
//        $ImagePath = $_SERVER["DOCUMENT_ROOT"] . '/public/images/logo/logo_getel.png';
        $ImagePath = $_SERVER["DOCUMENT_ROOT"] . '/images/logo/logo_getel.png';

//        $ImagePath1 = $_SERVER["DOCUMENT_ROOT"] . '/public/images/logo/logo_canal.png';
        $ImagePath1 = $_SERVER["DOCUMENT_ROOT"] . '/images/logo/logo_canal.png';

        $this->fpdf = new Fpdf;
        //Header
        $this->fpdf->AddPage("P");
        $this->fpdf->SetFont("Arial", 'B', 12);
        $this->fpdf->Image($ImagePath, 8, 4, 50, 0, 'png');
//        $this->fpdf->Image("{{ asset('images/logo/logo_getel.jpg) }}",10,6,50,0,'jpg');
        $this->fpdf->Cell(70);
        $this->fpdf->Cell(40, 13, 'RECU DE CAISSE', 0, 0, 'C');
        $this->fpdf->Cell(30);
        $this->fpdf->Image($ImagePath1, null, null, 50, 0, 'png');
//        $this->fpdf->Image("{{ asset('images/logo/logo_canal.jpg) }}",null,null,50,0,'jpg');

        $this->fpdf->SetFont("Arial", '', 8);
        $this->fpdf->Ln(3);
        $this->fpdf->Cell(60, 5, 'RCCM:DLA/2018/2016/B/1825', 0, 0);
        $this->fpdf->Cell(59, 5, '', 0, 1);//Fin de ligne

        $this->fpdf->Cell(110, 5, 'No Contribuable:MO51812705675P', 0, 0);
        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(35, 5, 'Nom du vendeur:', 0, 0);
        $this->fpdf->Cell(50, 5, Auth::user()->name, 0, 0);
        $this->fpdf->Cell(59, 5, '', 0, 1);//Fin de ligne
        $this->fpdf->Ln(2);
        $this->fpdf->SetFont("Arial", '', 10);
        $this->fpdf->Cell(110, 5, 'Adresse: Andem-Logpom', 0, 0);
        $this->fpdf->Cell(15, 5, 'Date:', 0, 0);
        $this->fpdf->Cell(50, 5, now(), 0, 1);//Fin de ligne
        $this->fpdf->Ln(1.5);

        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(30, 5, 'Nom et prenom:', 0, 0);
        $this->fpdf->SetFont("Times", '', 10);
        $this->fpdf->Cell(80, 5, strtoupper($data->nom_client) . " " . ucfirst(strtolower($data->prenom_client)), 0, 0);

        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(20, 5, 'Telephone:', 0, 0);
        $this->fpdf->SetFont("Times", '', 10);
        $this->fpdf->Cell(45, 5, $data->telephone_client, 0, 1);//Fin de ligne

        $this->fpdf->Ln(1.5);
        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(20, 5, 'N Abonne:', 0, 0);
        $this->fpdf->SetFont("Times", '', 10);
        $this->fpdf->Cell(50, 5, $data->num_abonne, 0, 0);

        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(20, 5, 'N Decodeur: ', 0, 0);
        $this->fpdf->SetFont("Times", '', 10);
        $this->fpdf->Cell(40, 5, '  ' . $data->num_decodeur, 0, 0);

        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(20, 5, 'Formule:', 0, 0);
        $this->fpdf->SetFont("Times", '', 10);
        $this->fpdf->Cell(40, 5, $data->nom_formule, 0, 1);//Fin de ligne
        $this->fpdf->Ln(1.5);
//        $this->fpdf->Cell(159, 5, '', 0, 1);
//        $this->fpdf->Cell(139, 5, '', 0, 1);
        $this->fpdf->Line(200, 150, 10, 150);

        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(35, 5, "Module d'activation:", 0, 0);
        $this->fpdf->SetFont("Times", '', 10);
        $this->fpdf->Cell(35, 5, 'CGA', 0, 0);

        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(20, 5, "Date debut:", 0, 0);
        $this->fpdf->SetFont("Times", '', 10);
        $this->fpdf->Cell(40, 5, "{$data->date_abonnement}", 0, 0);

        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(20, 5, "Date fin:", 0, 0);
        $this->fpdf->SetFont("Times", '', 10);
        $this->fpdf->Cell(35, 5, "{$data->date_reabonnement}", 0, 1);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', 'B', 10);

        $this->fpdf->Cell(90, 5, 'Designation', 1, 0,'C');
        $this->fpdf->Cell(45, 5, 'Duree/Nombre', 1, 0,'C');
        $this->fpdf->Cell(54, 5, 'Montant', 1, 1,'C');//Fin de ligne

        $this->fpdf->SetFont('Arial', '', 10);

        $this->fpdf->SetFont("Arial", '', 10);
        $this->fpdf->Cell(90, 5, 'Materiel', 1, 0);
        $this->fpdf->Cell(45, 5, $data->nb_materiel, 1, 0,'C');
        $this->fpdf->Cell(54, 5, "{$data->prix_materiel}", 1, 1,'C');//Fin de ligne

        $this->fpdf->SetFont("Arial", '', 10);
        $this->fpdf->Cell(90, 5, 'Abonnement', 1, 0);
        $this->fpdf->Cell(45, 5, $data->dureeA, 1, 0,'C');
        $this->fpdf->Cell(54, 5, "{$data->prix_formuleA}", 1, 1,'C');//Fin de ligne


        $this->fpdf->Cell(90, 5, 'Reabonnement', 1, 0);
        $this->fpdf->Cell(45, 5, $data->dureeR, 1, 0,'C');
        $this->fpdf->Cell(54, 5, " {$data->prix_formuleR}", 1, 1,'C');//Fin de ligne

        $this->fpdf->Cell(90, 5, 'Upgrade', 1, 0);
        $this->fpdf->Cell(45, 5, $data->dureeU, 1, 0,'C');
//            $this->fpdf->Cell(34, 5, $data->difference, 1, 1);//Fin de ligne
        $this->fpdf->Cell(54, 5, "{$data->prix_formuleU}", 1, 1,'C');//Fin de ligne

        //Total
        $this->fpdf->Cell(90, 5, '', 0, 0);
        $this->fpdf->SetFont("Arial", 'B', 10);
        $this->fpdf->Cell(45, 5, 'Total:', 0, 0,'R');
        $this->fpdf->Cell(54, 5, $data->total, 1, 1, 'C');//Fin de ligne

        $this->fpdf->Cell(209, 2, '', 0, 1);

        $this->fpdf->Cell(179, 5, 'Arrete le present recu a la somme de : ' . $data->total . ' FCFA', 0, 1);
        $this->fpdf->Line(200, 110, 10, 110);
//        $this->fpdf->Cell(159, 5, '', 0, 1);
        $this->fpdf->Cell(179, 5, '', 0, 1);
        $this->fpdf->Cell(179, 5, '', 0, 1);

        $this->fpdf->SetFont("Arial", '', 10);
        $this->fpdf->Cell(140, 5, 'Noms et signature du vendeur', 0, 0);
        $this->fpdf->Cell(50, 5, "Noms et signature du client", 0, 1,'C');
        $this->fpdf->Cell(109, 5, '', 0, 1);
        $this->fpdf->Cell(179, 5, '', 0, 1);
//        $this->fpdf->Cell(159, 5, '', 0, 1);
        $this->fpdf->Cell(130, 5, 'GETEL SARL', 0, 0);
        $this->fpdf->Cell(87, 5, strtoupper($data->nom_client) . " " . ucfirst(strtolower($data->prenom_client)), 0, 1,'C');

        $this->fpdf->Cell(179, 5, '', 0, 1);
        $this->fpdf->SetFont("Times", '', 9);
        $this->fpdf->Cell(115, 5, 'Important : Notre service apres vente reste a votre disposition.', 0, 1);
        $this->fpdf->Cell(155, 5, "En cas de probleme contacter nous au telephone: 694 662 294 ou email: contact@getel.cm", 0, 1);
        $this->fpdf->Output();
        exit;
    }

}
