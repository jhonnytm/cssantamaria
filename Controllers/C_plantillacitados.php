<?php
require '..//Public/fpdf/fpdf.php';
class PDF extends FPDF
{
    function Header()
    {
        $this->Image('..//Public/images/dirislc.jpeg', 10, 10, 50);
        //$this->SetFont('Arial', 'B', 12);
        //$this->Cell(10);
        //$this->Cell(200, 12, (''), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(50, 5, '', 0, 0, 'L', 0);
        $this->Cell(150, 8, utf8_decode('CENTRO DE SALUD SANTA MARÍA'), 0, 1, 'C');
        $this->Ln(5);
        //$this->Cell(285, 8, utf8_decode('PACIENTES CITADOS CON ORDENES DE LABORATORIO'), 1, 1, 'C');
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9);
        //$this->line(10, 250, 145, 250);;
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '', 0, 0, 'C');
        //$this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
