<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Stmt\Foreach_;

//include('C_plantillamuestras.php');
require '..//Public/fpdf/fpdf.php';
require('../Config/Conexion2.php');
include('C_anios.php');

$fechaactual = date('Y-m-d');
if (isset($_GET['fechaini'])) {
    //echo "bien";
    $fecha = $_GET['fechaini'];
    $sql = " SELECT * FROM ordenhistprof where Fechacita='$fecha' ";
    $consulta = $ConexionDB->query($sql);
    $filas = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($filas as $registro) :
        $nroorden = $registro->Nro_orden;
        $nroordenlab = $registro->NroOrdenLab;
        $fechaemision = $registro->FechaEmision;
        $estado = $registro->Estado;
        $nrodoc = $registro->NroDoc;
        $paciente = $registro->Paciente;
        $seguro = $registro->Desc_Seguro;
        $nrorecibo = $registro->Nrorecibofua;
        $estrategia = $registro->Desc_EstrategiaS;
        $prof = $registro->Nombres_Prof;
        $fechacita = $registro->FechaCita;
        $fechatermino = $registro->FechaTermino;
    endforeach;
    $pdf = new FPDF($orientation = 'L', $unit = 'mm', array(210, 297));
    $pdf->AddPage();
    $pdf->Image('..//Public/images/dirislc.jpeg', 10, 10, 50);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(50, 5, '', 0, 0, 'L', 0);
    $pdf->Cell(100, 5, utf8_decode('Centro de Salud SANTA MARÍA'), 0, 0, 'R', 1);
    $pdf->Cell(100, 5, 'Muestras de : ' . $fecha, 0, 1, 'R', 1);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->setY(18);
    $pdf->SetX(2);
    $pdf->Cell(285, 8, utf8_decode('PACIENTES CITADOS CON ORDENES DE LABORATORIO'), 1, 1, 'C');
    $pdf->Ln(2);
    $pdf->SetX(2);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(15, 5, utf8_decode('N° Orden '), 0, 0, 'C', 1);
    $pdf->Cell(25, 5, 'ORDEN LAB ', 0, 0, 'C', 1);
    $pdf->Cell(20, 5, utf8_decode('F. Emisión'), 0, 0, 'C', 1);
    $pdf->Cell(50, 5, utf8_decode('Paciente '), 0, 0, 'C', 1);
    $pdf->Cell(50, 5, utf8_decode('Profesional'), 0, 0, 'C', 1);
    $pdf->Cell(25, 5, utf8_decode('Condición '), 0, 0, 'C', 1);
    $pdf->Cell(20, 5, utf8_decode('N° recibo '), 0, 0, 'C', 1);
    $pdf->Cell(20, 5, utf8_decode('Estrategia '), 0, 0, 'C', 1);
    $pdf->Cell(20, 5, utf8_decode('F.Término '), 0, 0, 'C', 1);
    $pdf->Cell(20, 5, utf8_decode('Estado '), 0, 0, 'C', 1);
    $pdf->Cell(50, 5, utf8_decode('Exámenes Solicitados '), 0, 0, 'C', 1);
    $pdf->Ln(5);

    $sql = " SELECT * FROM ordenhistprof where Fechacita='$fecha' ";
    $consulta = $ConexionDB->query($sql);
    $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);
    foreach ($filas as $registro) :
        $nroordenn = $registro['Nro_orden'];
        $pdf->SetX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $registro['Nro_orden'], 0, 0, 'L', 1);
        //$pdf->Cell(30, 5, $registro['NroOrdenLab'], 0, 0, 'L', 1);
        $pdf->Cell(20, 5, $registro['FechaEmision'], 0, 0, 'L', 1);
        $pdf->Cell(50, 5, utf8_decode($registro['Paciente']), 0, 0, 'L', 1);
        $pdf->Cell(50, 5, utf8_decode($registro['Nombres_Prof']), 0, 0, 'L', 1);
        $pdf->Cell(25, 5, utf8_decode($registro['Sigla_Seguro']), 0, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode($registro['Nrorecibofua']), 0, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode($registro['Abrevia_ES']), 0, 0, 'C', 1);
        $pdf->Cell(20, 5, $registro['FechaTermino'], 0, 0, 'L', 1);
        $pdf->Cell(20, 5, $registro['Estado'], 0, 1, 'L', 1);

        $sqldet = "SELECT * FROM ORDENLABEXAMENES WHERE Nro_orden='$nroordenn'";
        $consultdet = $ConexionDB->prepare($sqldet);
        $consultdet->execute();
        $registrodet = $consultdet->fetchAll(PDO::FETCH_ASSOC);
        foreach ($registrodet as $filadet) :
            $pdf->SetX(25);
            $pdf->Cell(35, 5, utf8_decode($filadet['Desc_examen']), 0, 0, 'L', 1);
            $pdf->Cell(35, 5, ' -> ' . $filadet['Resultado_uno'], 0, 1, 'L', 1);
        endforeach;
    endforeach;
    $pdf->Output('Muestras tomadas ' . $fecha . '.pdf', 'D');
} else {
    echo "Algo anda mal";
}
