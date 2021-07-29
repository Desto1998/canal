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
    public function createPDF()
    {
        $this->fpdf = new Fpdf;
        // Column headings
        $header = array('Designation', 'Quantite', 'Prix unitaire', 'Prix total');
        //$data = $this->fpdf->LoadData('countries.txt');
        $this->fpdf->AddPage("L", ['100', '100']);
        $this->fpdf->SetFont("Times",'',12);    
        $this->fpdf->Cell(40,10,"Numero d'abonne:",0,1);
        $this->fpdf->Cell(40,10,'Date:',0,1);
        $this->fpdf->Cell(40,10,'Adresse:',0,1);
        $this->fpdf->Cell(40,10,'Nom du client:',0,1);
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(40,10,'Intitule: Description du produit:',0,1);
        $this->fpdf->Ln(5);
        //$this->fpdf->ImprovedTable($header,$data);
         
        $this->fpdf->Output();
        exit;
    }
    // Page header
	function Header()
	{
		// Logo
		$this->Image('2d_logo.png',10,6,30);
		// Arial bold 15
		$this->SetFont('Arial','B',15);
		// Move to the right
		$this->Cell(80);
		// Title
		$this->Cell(30,10,'FACTURE',1,0,'C');
		// Line break
		$this->Ln(20);
	}
    // Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,0,'Client',0,0);
	}
    // Better table
	function ImprovedTable($header, $data)
	{
		// Column widths
		$w = array(40, 35, 40, 45);
		// Header
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
		$this->Ln();
		// Data
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],'LR');
			$this->Cell($w[1],6,$row[1],'LR');
			$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
			$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
			$this->Ln();
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
	}
}
