<?php

date_default_timezone_set("America/Lima"); //Zona horaria de Peru
require_once('../Config/Conexion2.php');
echo $orden = ($_POST["nroorden"]);
echo $idexamen = ($_POST["idexamen"]);

echo $resultado = ($_POST['resultado']);
echo $muestrauno = date('Y-m-d H:i:s');
if (empty($_POST['resultado'])) {
    $resultado = "";
} else {
    $resultado = ($_POST['resultado']);
}

$estado = $_POST['estado'];

$sql = "UPDATE ORDENLABDETALLE
        SET MUESTRA_UNO=?, RESULTADO_UNO=?  
        WHERE nRO_ORDEN=? AND ID_EXAMEN=?";

$consulta = $ConexionDB->prepare($sql);
$consulta->execute([$muestrauno, $resultado, $orden, $idexamen]);

if ($consulta) {
    header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $orden . '&estado=' . $estado);
} else {
    echo "Errores";
}
