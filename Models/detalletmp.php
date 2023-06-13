<?php
include_once('../Config/Conexion2.php');


$fechaactual = date('Ymd');
$fechafiltro = date('Y-m-d');
$mifecha = date('Y-m-d H:m:s');

$sql = "SELECT COUNT(*) FROM ORDENLAB WHERE FechaEmision='$fechafiltro'";

$cant = $ConexionDB->query($sql);
$total = $cant->fetchColumn();
$nro = $total + 1;

$longitud = 4;
$NroOrden = substr(str_repeat(0, $longitud) . $nro, -$longitud);

$NroOrdenLab = $fechaactual . $NroOrden;

$Nroh = $_POST['txthc'];
$longitud = 8;
$NroHC = substr(str_repeat(0, $longitud) . $Nroh, -$longitud);

$sql1 = "SELECT * FROM histclinica WHERE Nro_HC ='$NroHC'";
$consulta = $ConexionDB->query($sql1);
$registro = $consulta->fetchAll(PDO::FETCH_OBJ);

$fechaemision = $fechaactual;
$estado = "PENDIENTE";
$impreso = "NO";

$Prof = $_POST['cboprof'];
$estrategia = $_POST['cboestrategia'];
$seguro = $_POST['cbocondseguro'];
$examen = $_POST['cboexamen'];

$sql = "INSERT INTO ORDENLABTEMP (Nroordenlab, Nro_HC, FechaEmision, Id_Prof, Id_EstrategiaS, Id_CondSeguro, estado, Id_Examen, Fecharegistro) 
VALUE (?,?,?,?,?,?,?,?,?)";
$sql = $ConexionDB->prepare($sql); // (:HC, :NroDoc, :Apepat, :Apemat, :Nombres, :Telef, :Celular, : Direccion)");
$resultado = $sql->execute([$NroOrdenLab, $NroHC,  $fechaemision, $Prof, $estrategia, $seguro, $estado, $examen, $mifecha,]);

if ($resultado) {
    //echo "Datos guardados exitosamentes";
    header('Location: ../Views/ordenlabreg.php');
} else {
    //echo "NO se han insertado los datos";
}
