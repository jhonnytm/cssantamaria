<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Stmt\Foreach_;

//include('C_plantilla.php');
require '..//Public/fpdf/fpdf.php';
require('../Config/Conexion2.php');
include('C_anios.php');

$ordenlab = $_GET['Nro_orden'];
$estado = $_GET['estado'];

if ((isset($ordenlab))) {

    $sql = "SELECT * FROM ORDENLAB WHERE Nro_orden='$ordenlab'";
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute();
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $orden = $row->Nro_orden;
        $nroordenlab = $row->NroOrdenLab;
        $nrohc = $row->Nro_HC;
        $fechaemision = $row->FechaEmision;
        $prof = $row->Id_Prof;
        $estrategia = $row->Id_EstrategiaS;
        $seguro = $row->Id_CondSeguro;
        $nrorecibofua = $row->Nrorecibofua;
        $estado = $row->Estado;
        $fechatermino = $row->FechaTermino;
        $fechaimpresion = $row->Fechaimpresion;
    endforeach;
    $fechaimpresion = date('Y-m-d H:i:s');

    $sql1 = "SELECT * FROM HISTCLINICA WHERE nRO_hC='$nrohc'";
    $consulta = $ConexionDB->query($sql1);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $nombrespaciente = $row->Nombres;
        $sexo = $row->Sexo_Hc;
        $fechanac = $row->FechaNac_HC;
        $celular = $row->Celular_hc;
        $nrodoc = $row->NroDoc;
    endforeach;

    $fechainicio = strtotime(date('Y-m-d'));
    $fechafin = strtotime($fechanac);
    $fechas = round(($fechainicio - $fechafin) / 31536000, 1);
    $decimalanio = explode(".", $fechas);
    $anio = $decimalanio[0] . " Años ";
    //$mess = round(($decimalanio[1] * 12) / 10, 1);
    //$decimalmes = explode(".", $mess);
    //$mes = $decimalmes[0] . " meses ";
    $edad = $anio; //. $mes;

    $sql = "SELECT * FROM profesionales WHERE Id_prof='$prof'";
    $consulta = $ConexionDB->query($sql);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $nombresprof = $row->Nombres_Prof;
    endforeach;

    $sql = "SELECT * FROM estrasanitaria WHERE Id_estrategias='$estrategia'";
    $consulta = $ConexionDB->query($sql);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $nombreestrategia = $row->Desc_EstrategiaS;
    endforeach;

    $sql = "SELECT * FROM condseguro WHERE Id_CondSeguro='$seguro'";
    $consulta = $ConexionDB->query($sql);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $nombreseguro = $row->Desc_Seguro;
    endforeach;
    $impreso = "SI";
    $sql = "UPDATE ORDENLAB 
        SET 
        Impreso=?, FechaImpresion=? 
        WHERE Nro_orden=?";
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute([$impreso, $fechaimpresion, $ordenlab]);

    $pdf = new FPDF($orientation = 'P', $unit = 'mm', array(210, 270));
    $pdf->AddPage();
    $pdf->Image('..//Public/images/dirislc.jpeg', 10, 10, 50);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(50, 5, '', 0, 0, 'L', 0);
    $pdf->Cell(85, 5, utf8_decode('Centro de Salud SANTA MARÍA'), 0, 1, 'R', 1);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->setY(18);
    $pdf->Cell(135, 8, utf8_decode('RESULTADO DE ANÁLISIS DE LABORATORIO'), 1, 1, 'C');
    $pdf->Ln(2);
    $pdf->setY(30);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(15, 4, utf8_decode('Paciente:'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(60, 4, utf8_decode($nombrespaciente), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(20, 4, utf8_decode('Ingreso por :'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 4, $nombreseguro, 0, 1, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(15, 4, utf8_decode('Edad :'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(30, 4, utf8_decode($edad), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(10, 4, ('Sexo :'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(20, 4, $sexo, 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(20, 4, utf8_decode('Fecha Orden :'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 4, $fechaemision, 0, 1, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(15, 4, utf8_decode('DNI :'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(30, 4, $nrodoc, 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(10, 4, utf8_decode('HC:'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(20, 4, $nrohc, 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(20, 4, utf8_decode('Fecha Actual :'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 4, $fechaimpresion, 0, 1, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(15, 4, utf8_decode('Celular:'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(30, 4, $celular, 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 4, utf8_decode('F o B:'), 0, 0, 'L', 1);
    $pdf->Cell(20, 4, $nrorecibofua, 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(20, 4, utf8_decode('Profesional:'), 0, 0, 'L', 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 4, $nombresprof, 0, 1, 'L', 1);
    $pdf->Ln(5);

    $pdf->Cell(30, 4, 'EXAMEN ', 0, 0, 'C', 1);
    $pdf->Cell(70, 4, 'RESULTADO ', 0, 0, 'C', 1);
    $pdf->Cell(18, 4, 'UNID MED', 0, 0, 'C', 1);
    $pdf->Cell(15, 4, 'V. NOMINAL ', 0, 1, 'C', 1);

    $pdf->Ln(5);


    $sql1 = "SELECT Id_CategExam, COUNT(*) as cant FROM ordenlabexamenes WHERE Nro_orden='$ordenlab' group BY ID_categexam ";
    $consulta = $ConexionDB->query($sql1);
    $registro = $consulta->fetchAll(PDO::FETCH_ASSOC);
    foreach ($registro as $row) :
        $examentipo = $row['Id_CategExam'];
        $sql5 = "SELECT * FROM categexamenes WHERE Id_CategExam='$examentipo'";
        $consulta5 = $ConexionDB->query($sql5);
        $registro5 = $consulta5->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro5 as $r) :
            $nombreexamen = $r->Desc_CategExam;
        endforeach;
        $pdf->Cell(135, 5, utf8_decode($nombreexamen), 1, 1, 'L', 1);

        $sql2 = "SELECT *  from ordenlabexamenes  where nro_orden='$ordenlab' and Id_categExam='$examentipo'";
        $consulta2 = $ConexionDB->query($sql2);
        $registro2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);
        $pdf->Ln(1);
        foreach ($registro2 as $reg) :
            $nrodetalle = $reg['Nro_detalle'];
            $idexamen = $reg['Id_Examen'];
            $sqlbusqueda = "SELECT * FROM ordenlabsubdet3 WHERE NRO_DETALLE='$nrodetalle' AND ID_EXAMEN='$idexamen'";
            $consulta3 = $ConexionDB->query($sqlbusqueda);
            $registro3 = $consulta3->fetchAll(PDO::FETCH_ASSOC);
            if (empty($registro3)) {


                $pdf->Cell(45, 4, utf8_decode($reg['Desc_examen']), 0, 0, 'L', 1);
                $pdf->Cell(55, 4, $reg['Resultado_uno']/*.' '.$reg['Unidad_med']*/, 0, 0, 'C', 1);
                $pdf->Cell(15, 4, $reg['Unidad_med'], 0, 0, 'C', 1);
                $pdf->Cell(15, 4, $reg['Valor_min'] . " -" . $reg['Valor_max'], 0, 1, 'C', 1);
            } else {
                $pdf->Cell(45, 4, utf8_decode($reg['Desc_examen']), 0, 0, 'L', 1);
                $pdf->Cell(55, 4, $reg['Resultado_uno']/*.' '.$reg['Unidad_med']*/, 0, 0, 'C', 1);
                $pdf->Cell(15, 4, $reg['Unidad_med'], 0, 0, 'C', 1);
                $pdf->Cell(15, 4, $reg['Valor_min'] . " -" . $reg['Valor_max'], 0, 1, 'C', 1);
                foreach ($registro3 as $fila) :
                    $pdf->SetX(12);
                    $pdf->Cell(20, 4, $fila['Descripcion2'], 0, 0, 'L', 1);
                    $pdf->Cell(2, 4, '-', 0, 0, 'C', 1);
                    $pdf->Cell(45, 4, utf8_decode($fila['Descripcion']), 0, 0, 'L', 1);
                    $pdf->Cell(45, 4, $fila['Resultado'], 0, 1, 'L', 1);
                endforeach;
            }

        //$pdf->Cell(40, 5, $reg['Valor_max'], 0, 1, 'C', 1);
        endforeach;
        $pdf->Ln(2);
    endforeach;
    $pdf->Output($nombrespaciente . '.pdf', 'D');
}
