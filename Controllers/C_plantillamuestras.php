<?php
require '..//Public/fpdf/fpdf.php';
class PDF extends FPDF
{
    function Header()
    {
        //$pdf->AddPage();
        $this->Image('..//Public/images/dirislc.jpeg', 10, 10, 50);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(50, 5, '', 0, 0, 'L', 0);
        $this->Cell(80, 5, utf8_decode('Centro de Salud SANTA MARÍA'), 0, 0, 'R', 1);
        $this->SetFillColor(255, 255, 255);
        $this->setY(18);
        $this->SetX(2);
        $this->Cell(204, 8, utf8_decode('PACIENTES CITADOS CON ÓRDENES DE LABORATORIO'), 1, 1, 'C');
        $this->Ln(2);
        $this->SetX(2);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(8, 5, utf8_decode('Nro'), 0, 0, 'C', 1);
        $this->Cell(18, 5, utf8_decode('F. Emisión'), 0, 0, 'C', 1);
        $this->Cell(12, 5, utf8_decode('HC'), 0, 0, 'C', 1);
        $this->Cell(35, 5, utf8_decode('Paciente '), 0, 0, 'C', 1);
        $this->Cell(35, 5, utf8_decode('Profesional'), 0, 0, 'C', 1);
        $this->Cell(15, 5, utf8_decode('Condición '), 0, 0, 'C', 1);
        $this->Cell(20, 5, utf8_decode('N° recibo '), 0, 0, 'C', 1);
        $this->Cell(15, 5, utf8_decode('Estrategia '), 0, 0, 'C', 1);
        $this->Cell(18, 5, utf8_decode('F.Término '), 0, 0, 'C', 1);
        $this->Cell(20, 5, utf8_decode('Estado'), 0, 0, 'C', 1);
        $this->Cell(5, 5, utf8_decode('Ex.S.'), 0, 1, 'C', 1);
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
