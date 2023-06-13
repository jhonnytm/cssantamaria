<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
require_once('../Config/Conexion2.php');
$orden = ($_POST["nroorden"]);
$idexamen = ($_POST["idexamen"]);
$estado = $_POST['estado'];
$nrodetalle = $_POST['nrodetalle'];
$examen = $_POST['cboexamsub'];

//empty($_POST['cboexamsub']) ||
if (empty($_POST['resultado'])) {
    //header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $orden . '&estado=' . $estado);

    header('location:  ../Views/resultadoedit2.php?Nro_orden=' . $orden . '&idexamen=' . $idexamen . '&estado=' . $estado);
    die();
}

$resultado = strtoupper(($_POST['resultado']));
$fecha = date('Y-m-d H:i:s');

$sqlbusca = "SELECT * FROM ORDENLABSUBDET WHERE nro_detalle='$nrodetalle' and id_examen='$idexamen ' and id_examsubcat='$examen'";
$consulta = $ConexionDB->query($sqlbusca);
$rpta = $consulta->fetchColumn();

if (empty($rpta)) {
    $sql = "INSERT INTO 
    ORDENLABSUBDET (Nro_detalle, Id_examen, Id_examsubcat, resultado, fecha) 
    VALUE (?,?,?,?,?)";
    $consulta = $ConexionDB->prepare($sql);
    $resultado = $consulta->execute([$nrodetalle, $idexamen, $examen, $resultado, $fecha]);

    $resultados = ":";
    $sql2 = "UPDATE ORDENLABDETALLE
            SET MUESTRA_UNO=?, RESULTADO_UNO=?  
            WHERE nRO_ORDEN=? AND ID_EXAMEN=?";

    $consulta2 = $ConexionDB->prepare($sql2);
    $consulta2->execute([$fecha, $resultados, $orden, $idexamen]);

    if ($resultado) {
        header('location:  ../Views/resultadoedit2.php?Nro_orden=' . $orden . '&idexamen=' . $idexamen . '&estado=' . $estado);
        exit();
    } else {
        echo "NO se han insertado los datos";
        return;
    }
} else {
    $sql2 = "UPDATE
            ORDENLABSUBDET
            SET resultado=?, fecha=?
            WHERE  Nro_detalle=? and Id_examen=? and id_examsubcat=?";
    $consulta2 = $ConexionDB->prepare($sql2);
    $resultado2 = $consulta2->execute([$resultado, $fecha, $nrodetalle, $idexamen, $examen]);

    $resultados = ":";
    $sql2 = "UPDATE ORDENLABDETALLE
            SET MUESTRA_UNO=?, RESULTADO_UNO=?  
            WHERE nRO_ORDEN=? AND ID_EXAMEN=?";

    $consulta2 = $ConexionDB->prepare($sql2);
    $consulta2->execute([$fecha, $resultados, $orden, $idexamen]);

    if ($resultado2) {
        header('location:  ../Views/resultadoedit2.php?Nro_orden=' . $orden . '&idexamen=' . $idexamen . '&estado=' . $estado);
        exit();
    } else {
        echo "NO se han insertado los datos";
        return;
    }
}
