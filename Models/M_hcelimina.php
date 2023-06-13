<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');
//*****  */
$fechaactual = date('Ymd');
$HC = ($_GET["Nro_HC"]);
//die();
$sql = "DELETE FROM HISTORIACLINICA WHERE Nro_HC=?";
$elimina = $ConexionDB->prepare($sql);
$resultado = $elimina->execute([$HC]);

if ($resultado) {
    header('Location: ../Views/hc.php');
} else {
    //echo "Hay errores... Verifica";
}
