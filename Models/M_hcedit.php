<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
use function PHPUnit\Framework\isNull;

include_once('../Config/Conexion2.php');

$HC = $_POST['txthc'];

$NroHC = $HC;
//echo "  " . $tipodoc = $_POST['cbotipodoc'];
$NroDoc = $_POST['txtNrodoc'];
$Apepat = strtoupper($_POST['txtapepat']);
$Apemat = strtoupper($_POST['txtapemat']);
$nombres = strtoupper($_POST['txtnombres']);
//$estadociv = $_POST['cboestadocivil'];
$genero = $_POST['cbogenero'];
//$seguro = $_POST['cbocondseguro'];
//$etnia = $_POST['cboetnia'];
//$Telefono = $_POST['txttelefono'];
$Celular = $_POST['txtcelular'];
$Direccion = strtoupper($_POST['txtdireccion']);
//$dpto = $_POST['cbodpto'];
$mifecha = date('Y-m-d H:i:s');
$fecnac=$_POST['txtfechanac'];
$estado = "ACTIVO";
$sql = "UPDATE 
            HISTORIACLINICA 
            SET 
            NroDoc=?, Apepat_HC=?, Apemat_HC=?, Nombres_HC=?, Sexo_HC=?, FechaNac_HC=?, Celular_HC=?, 
            Direccion_HC=?, Estado=?, FechaEdit_HC=? 
            WHERE Nro_HC=?";
$consulta = $ConexionDB->prepare($sql);
$consulta->execute([
    $NroDoc, $Apepat, $Apemat, $nombres, $genero, $fecnac, $Celular,
    $Direccion, $estado, $mifecha, $NroHC
]);
if ($consulta) {
    header('Location: ../Views/hc.php');
} else {
    header('Location: ../Views/hc.php');
}
