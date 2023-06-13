<?php
include_once('../Config/Conexion2.php');
include('C_plantillacitados.php');

$horario = $_GET['nro'];
$fecha = $_GET['fecha'];
$prof = $_GET['prof'];

$sql = "SELECT * FROM citashc WHERE id_horario='$horario'and fecha='$fecha'  order by orden";
$consulta = $ConexionDB->prepare($sql);
$consulta->execute();
$registros = $consulta->fetchAll(PDO::FETCH_OBJ);

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetY(20);
$pdf->Cell(190, 10, ('LISTADO DE CITADOS'), 1, 0, 'C');
$pdf->SetY(35);
$pdf->Cell(100, 5, 'Profesional :' . $prof, 0, 0, 'C', 1);
$pdf->Cell(100, 5, 'Fecha :' . $fecha, 0, 0, 'C', 1);
$pdf->SetY(45);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 5, 'Ord. ', 0, 0, 'C', 1);
$pdf->Cell(20, 5, 'HIST C. ', 0, 0, 'C', 1);
$pdf->Cell(20, 5, 'DNI ', 0, 0, 'C', 1);
$pdf->Cell(70, 5, 'PACIENTE', 0, 0, 'C', 1);
$pdf->Cell(20, 5, utf8_decode('CONDICIÓN'), 0, 0, 'C', 1);
$pdf->Cell(30, 5, 'HORA INICIO', 0, 0, 'C', 1);
$pdf->Cell(30, 5, 'HORA FIN', 0, 0, 'C', 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 9);
foreach ($registros as $registro) {
    $pdf->Cell(10, 5, $registro->orden, 0, 0, 'L', 1);
    $pdf->Cell(20, 5, $registro->Nro_HC, 0, 0, 'L', 1);
    $pdf->Cell(20, 5, $registro->NroDoc, 0, 0, 'L', 1);
    $pdf->Cell(80, 5, utf8_decode($registro->Nombres), 0, 0, 'L', 1);
    $pdf->Cell(20, 5, $registro->Sigla_Seguro, 0, 0, 'L', 1);
    $pdf->Cell(30, 5, $registro->horainicio, 0, 0, 'L', 1);
    $pdf->Cell(30, 5, $registro->horafin, 0, 1, 'L', 1);
}
//$pdf->AddPage();

$pdf->Output('Citados_' . $fecha . '.pdf', 'D');
