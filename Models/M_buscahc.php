<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
if (!isset($_POST["hc"])) {
    return;
}
include_once("../Config/Conexion2.php");
$hc = $_POST["hc"];

$longitud = 8;
$NroHC = substr(str_repeat(0, $longitud) . $hc, -$longitud);

$sql = "SELECT * FROM HISTCLINICA WHERE Nro_Hc='$NroHC'";
$consulta = $ConexionDB->prepare($sql);
$registro = $consulta->fetchAll(PDO::FETCH_OBJ);
foreach ($registro as $row) :
    $nrodoc = $row->NroDoc;
    $nombres = $row->Nombres_HC;
    $sexo = $row->Sexo_Hc;
    $celular = $row->Celular_HC;
    $fechanac = $row->FechaNac_HC;

endforeach;

if (!$registro) {
    header("Location: ../Views/ordenlabreg1.php?status=4");
    exit;
} else {
    header("Location: ../Views/ordenlabreg1.php?status=6");
}
header("Location: ../Views/ordenlabreg1.php");
