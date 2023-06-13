<?php
require '..//Public/fpdf/fpdf.php';
$pdf = new Fpdf('P', 'mm', array(200, 100));
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', '9');
$pdf->SetX(50);
$pdf->Cell(100, 10, 'HOla mUndo', 1, 1, 'C');
$y = $pdf->GetY();
$pdf->SetXY(50, 50);
$pdf->Cell(100, 10, 'HOla mUndo', 1, 1, 'C');
$pdf->SetY($y + 60);
$pdf->MultiCell(100, 5, 'holasssss sadfasfa afsaf asfas  asfasfasdfsadf asfasfasf asfas afa sfas fas fas fasfasd asf', 1, 'L', 0);
$pdf->Output();
