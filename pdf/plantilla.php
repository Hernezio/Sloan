<?php
	require 'fpdf/fpdf.php';
	class PDF extends FPDF {
		function Header() {
			$this->SetFont('Arial','B',15);
			$this->Cell(37);
			$this->Cell(120,20, 'Reporte De Incidencias',0,0,'C');
			$this->Ln(10);
			$this->Cell(190,20, 'SLOAN',0,0,'C');
			$this->Ln(30);
		}
		
		function Footer() {
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}		

	}
?>