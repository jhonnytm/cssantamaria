<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

$orden = ($_GET["Nro_orden"]);
$idexamen = ($_GET["idexamen"]);
$estado = $_GET['estado'];

/*$sql = "DELETE FROM ordenlabdetalle WHERE Nro_orden='$orden' and Id_examen='$idexamen'";
$elimina = $ConexionDB->prepare($sql);
$resultado = $elimina->execute();

$sql1 = "SELECT  COUNT(Nro_orden) FROM ORDENLABDETALLE WHERE NRO_ORDEN='$orden'";
$consulta = $ConexionDB->query($sql1);query
$nro = $consulta->fetchColumn();*/
$sqlconsulta = "SELECT * FROM ORDENLABDETALLE WHERE nRO_ORDEN='$orden' AND ID_EXAMEN='$idexamen'";
$consulta2 = $ConexionDB->query($sqlconsulta);
$resultado2 = $consulta2->fetchAll(PDO::FETCH_OBJ);
foreach ($resultado2 as $reg) :
    $resultado = $reg->Resultado_uno;
endforeach;

if (empty($resultado)) {
    echo "no se puede finalizar si no hay resultado ingresaado";
    $estado = "PENDIENTE";
    header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $orden . '&estado=' . $estado);
} else {
    $estado = "FINALIZADO";
    $fechatermino = date('Y-m-d H:i:s');

    $sql = "UPDATE
        ORDENLAB
        SET Estado=?, FechaTermino=?
        WHERE  Nro_orden=?";
    $consulta = $ConexionDB->prepare($sql);
    $resultado = $consulta->execute([$estado, $fechatermino, $orden]);

    if ($resultado) {
        header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $orden . '&estado=' . $estado);
    } else {
        echo "Hay errores... Verifica";
    }
}
