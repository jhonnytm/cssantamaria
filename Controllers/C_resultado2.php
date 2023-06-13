<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Stmt\Foreach_;

//include('C_plantilla.php');
//require '..//Public/fpdf/fpdf.php';
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
    $mess = round(($decimalanio[1] * 12) / 10, 1);
    $decimalmes = explode(".", $mess);
    $mes = $decimalmes[0] . " meses ";
    $edad = $anio . $mes;

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
        echo $nombreexamen .  ":" . $row['cant'] . ' <br>';
        $sql2 = "SELECT *  from ordenlabexamenes  where nro_orden='$ordenlab' and Id_categExam='$examentipo'";
        $consulta2 = $ConexionDB->query($sql2);
        $registro2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($registro2 as $reg) :
            echo " - " . $reg['Desc_examen'];
            echo $reg['Resultado_uno'];
            echo $reg['Unidad_med'];
            echo $reg['Valor_min'];
            echo $reg['Valor_max'] . '  <br>';
        endforeach;
    endforeach;
}
