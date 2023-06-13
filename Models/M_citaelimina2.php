<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

$nro = ($_GET["nro"]);
$cita = ($_GET["cita"]);
$hc = ($_GET["hc"]);
$nroorden = ($_GET["nro_orden"]);

$sql = "DELETE FROM citas WHERE Nro_cita='$cita'";
$elimina = $ConexionDB->prepare($sql);
$resultado = $elimina->execute();

if ($resultado) {
    header('Location: ../Views/citapaciente2.php?Nro=' . $nro . '&Nro_orden=' . $nroorden . '&hc=' . $hc);
    //    citapaciente2.php?Nro=118&hc=00050555&Nro_orden=524
} else {
    echo "Hay errores... Verifica";
}
