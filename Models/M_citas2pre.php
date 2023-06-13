<?php
include('../Config/Conexion2.php');

/*$fecha = date('Y-m-d');
$sql = "SELECT * FROM turnoxdia WHERE FECHA >='$fecha' ORDER BY FECHA ASC";

/*if (isset($_POST['buscar'])) {
    $mifecha = $_POST['fechacita'];
    $sql = "SELECT * FROM TURNOXDIA WHERE FECHA='$mifecha'";
} else {
}
$consulta = $ConexionDB->prepare($sql);
$consulta->execute();
$registro = $consulta->fetchAll(PDO::FETCH_OBJ);*/

if (empty($_GET['hc'])) {
    $hc = "";
} else {
    $hc = $_GET['hc'];
}
$estado = $_GET['estado'];
$orden = $_GET['Nro_orden'];


if ($estado === "FINALIZADO") {

    header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $orden . '&estado=' . $estado);
} else {
    header('Location: ../Views/citas2.php?hc=' . $hc . '&Nro_orden=' . $orden . '&estado=' . $estado);
    //echo $nrohc &Nro_orden=<?php echo $row->Nroorden &estado=<?php echo $estado 
}
