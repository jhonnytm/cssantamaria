<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Stmt\Foreach_;

include('C_plantillamuestras.php');
//require '..//Public/fpdf/fpdf.php';
require('../Config/Conexion2.php');
include('C_anios.php');

$fechaactual = date('Y-m-d');
if (isset($_GET['fechaini'])) {
    //echo "bien";
    $fecha = $_GET['fechaini'];
    $sql = " SELECT * FROM ordenhistprof where date(Fechatermino)='$fecha' order by Paciente asc";
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
    $pdf = new PDF($orientation = 'P', $unit = 'mm', array(210, 297));
    $pdf->AddPage();
    $pdf->SetFillColor(255, 255, 255);


    $sql2 = "SELECT * FROM ordenhistprof where date(Fechatermino)='$fecha' order by Paciente asc";
    $consulta = $ConexionDB->query($sql);
    $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $pdf->SetX(15);
    $pdf->Cell(20, 5, 'Muestras de :' . $fecha, 0, 1, 'L', 1);
    foreach ($filas as $registro) :
        $nroordenn = $registro['Nro_orden'];
        $pdf->SetX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(8, 5, $registro['Nro_orden'], 0, 0, 'L', 1);
        $pdf->Cell(16, 5, $registro['FechaEmision'], 0, 0, 'L', 1);
        $pdf->Cell(14, 5, $registro['Nro_HC'], 0, 0, 'L', 1);
        $pdf->Cell(35, 5, utf8_decode($registro['Paciente']), 0, 0, 'L', 1);
        $pdf->Cell(35, 5, utf8_decode($registro['Nombres_Prof']), 0, 0, 'L', 1);
        $pdf->Cell(15, 5, utf8_decode($registro['Sigla_Seguro']), 0, 0, 'C', 1);
        $pdf->Cell(20, 5, utf8_decode($registro['Nrorecibofua']), 0, 0, 'C', 1);
        $pdf->Cell(12, 5, utf8_decode($registro['Abrevia_ES']), 0, 0, 'C', 1);
        $pdf->Cell(20, 5, $registro['FechaTermino'], 0, 0, 'L', 1);
        $pdf->Cell(20, 5, $registro['Estado'], 0, 1, 'L', 1);

        $sqldet = "SELECT * FROM ORDENLABEXAMENES WHERE Nro_orden='$nroordenn'";
        $consultdet = $ConexionDB->prepare($sqldet);
        $consultdet->execute();
        $registrodet = $consultdet->fetchAll(PDO::FETCH_ASSOC);
        foreach ($registrodet as $filadet) :
            $pdf->SetX(40);
            $pdf->Cell(35, 5, utf8_decode($filadet['Desc_examen']), 0, 0, 'L', 1);
            $pdf->Cell(35, 5, ' -> ' . $filadet['Resultado_uno'], 0, 1, 'L', 1);
        endforeach;
    endforeach;
    $pdf->Output('Muestras tomadas ' . $fecha . '.pdf', 'D');
} else {
    echo "Algo anda mal";
}
