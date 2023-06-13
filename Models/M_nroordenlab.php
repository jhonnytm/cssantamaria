<?php
include_once('../Config/Conexion2.php');

Public function NrodeordenLab(){

}
$fechaactual = date('Ymd');
$fechafiltro = date('Y-m-d');
$mifecha = date('Y-m-d H:i:s');

$sql = "SELECT COUNT(*) FROM ORDENLAB WHERE FechaEmision='$fechafiltro'";

$cant = $ConexionDB->query($sql);
$total = $cant->fetchColumn();
$nro = $total + 1;

$longitud = 4;
$NroOrden = substr(str_repeat(0, $longitud) . $nro, -$longitud);

$NroOrdenLab = $fechaactual . $NroOrden;
