<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

$nro = ($_GET["Nro"]);

$sql = "DELETE FROM TURNOSXDIA WHERE ID_HORARIO=?";
$elimina = $ConexionDB->prepare($sql);
$resultado = $elimina->execute([$nro]);

if ($resultado) {
    header('Location: ../Views/turnosxdia.php');
} else {
    echo "Hay errores... Verifica";
}
