<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
require_once('../Config/Conexion2.php');


$resultado = ($_POST['resultado']);
$muestrauno = date('Y-m-d H:i:s');

if (empty($_POST['resultado'])) {
    $resultado = "";
} else {
    $resultado = ($_POST['resultado']);
    $id = ($_POST['idexamsubcat']);
}
$orden = ($_POST["nroorden"]);
$estado = $_POST['estado'];
$nro_orden = $_POST['nroorden'];

$nro_detalle = $_POST['nrodetalle'];
$idexamen = ($_POST["idexamen"]);

$sqlexam = "SELECT count(Id_Examen) FROM examsubcat where Id_examen='$idexamen'";
$consulta = $ConexionDB->query($sqlexam);
$cant = $consulta->fetchColumn();

/*$sqlexam = "SELECT count(nro_detalle) FROM ordenlabsubdet where nro_detalle='$nro_detalle' and Id_Examen='$idexamen'";
$consulta = $ConexionDB->query($sqlexam);
$cant = $consulta->fetchColumn();*/

if ($cant > 0) {
    $sql = "UPDATE ORDENLABSUBDET
            SET resultado=?, fecha=?
            WHERE Nro_detalle=? AND id_examen=? AND id_examsubcat=?";

    /*$sql = "INSERT INTO ORDENLABSUBDET (Nro_detalle, id_examen,id_examsubcat, resultado, fecha) 
            VALUE (?,?,?,?,?)";*/
    $inserta = $ConexionDB->prepare($sql);
    $guarda = $inserta->execute([$resultado, $muestrauno, $nro_detalle, $idexamen, $id]);

    $resultado = "DETALLADO";
    $sql2 = "UPDATE ORDENLABDETALLE
            SET MUESTRA_UNO=?, RESULTADO_UNO=?  
            WHERE nRO_ORDEN=? AND ID_EXAMEN=?";

    $consulta2 = $ConexionDB->prepare($sql2);
    $consulta2->execute([$muestrauno, $resultado, $orden, $idexamen]);
} else {
    $sql = "UPDATE ORDENLABDETALLE
            SET MUESTRA_UNO=?, RESULTADO_UNO=?  
            WHERE nRO_ORDEN=? AND ID_EXAMEN=?";

    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute([$muestrauno, $resultado, $orden, $idexamen]);
}

if ($guarda) {
    //echo 'swal("Good job!", "You clicked the button!", "success")';
    header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $orden . '&estado=' . $estado); //Views/ordenlabview.php?Nro_orden=512&estado=PENDIENTE#resultadoedit_1
    //header('Location: ../Views/ordenlabview.php?Nro_orden=' . $orden . '&estado=' . $estado);
} else {
    echo "Errores";
}
