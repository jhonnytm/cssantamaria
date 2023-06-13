<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
session_start();
include_once('../Config/Conexion2.php');

$mifecha = $_POST['fecha'];

if (empty($_POST['cbocartera']) || empty($_POST['cboconsultorio']) || empty($_POST['cboprof'] || empty($_POST['cboturno']))) {
    header('Location:../Views/turnosxdia.php');
    die();
}
$mifechacrea = date('Y-m-d H:i:s');

$cartera = $_POST['cbocartera'];
/*$Consul = $_POST['cboconsultorio'];
$Prof = $_POST['cboprof'];
$turno = $_POST['cboturno'];
$Nro = $mifecha . $cartera . $Consul . $Prof . $turno;*/

/*if (empty($_POST['txtcupos'])) {
    $cupos = 10;
} elseif ($_POST['txtcupos'] < 0) {
    header('Location:../Views/turnosxdia1.php');
} else {
    $cupos = $_POST['txtcupos'];
}

if (empty($_POST['txtadicionales'])) {
    $adic = 2;
} elseif ($_POST['txtadicionales'] < 0) {
    header('Location:../Views/turnosxdia.php');
} else {
    $adic = $_POST['txtadicionales'];
}*/

$sql = " SELECT count(*) FROM turnosxdia where nro='$Nro'";
$consulta = $ConexionDB->query($sql);
$cant = $consulta->fetchColumn();

$Nro2 = $mifecha . $cartera . $Consul . $Prof;
$sql2 = " SELECT count(*) FROM turnosxdia where nro2='$Nro2'";
$consulta2 = $ConexionDB->query($sql2);
$cant2 = $consulta->fetchColumn();

if ($cant == 1) {
    echo "Lo siento, pero el profesional ya fue asignado a dicho turno";
    header('Location:../Views/turnosxdia.php');
} elseif ($cant2 == 1) {
    header('Location:../Views/turnosxdia.php');
} else {
    $sql = "INSERT INTO TURNOSXDIA
    (Nro, Fecha, Id_cartera, Id_consultorio, Id_Prof, Id_turno, NroCupos, Adicionales, FechaCrea) 
    VALUE (?,?,?,?,?,?,?,?,?)";
    $consulta = $ConexionDB->prepare($sql);
    $resultado = $consulta->execute([$Nro, $mifecha, $cartera, $Consul, $Prof, $turno, $cupos, $adic, $mifechacrea]);

    if ($resultado) {
        header('Location: ../Views/turnosxdia.php');
    } else {
        header('Location: ../Views/turnosxdia.php');
    }
}
