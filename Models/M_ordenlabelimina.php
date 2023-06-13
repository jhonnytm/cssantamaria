<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

$orden = ($_GET["Nro_orden"]);
$idexamen = ($_GET["idexamen"]);
$estado = $_GET['estado'];

$sqlbusca = "SELECT resultado_uno FROM ORDENLABDETALLE WHERE Nro_orden='$orden' and Id_examen='$idexamen'";
$consulta = $ConexionDB->query($sqlbusca);
$busca = $consulta->fetchColumn();

if (empty($busca)) {
    $sql = "DELETE FROM ordenlabdetalle WHERE Nro_orden='$orden' and Id_examen='$idexamen'";
    $elimina = $ConexionDB->prepare($sql);
    $resultado = $elimina->execute();

    $sql1 = "SELECT  COUNT(Nro_orden) FROM ORDENLABDETALLE WHERE NRO_ORDEN='$orden'";
    $consulta = $ConexionDB->query($sql1);
    $nro = $consulta->fetchColumn();

    $sql = "UPDATE
            ORDENLAB
            SET registros=?
            WHERE  Nro_orden=?";
    $consulta = $ConexionDB->prepare($sql);
    $resultado = $consulta->execute([$nro, $orden]);

    if ($resultado) {
        header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $orden . '&estado=' . $estado);
    } else {
        echo "Hay errores... Verifica";
    }
} else {
    header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $orden . '&estado=' . $estado);
}
