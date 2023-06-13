<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

$nroorden = $_POST['ordenlab'];
$nroordenlab = $_POST['nroordenlab'];

if (empty($_POST['cboexamen'])) {
    $examen = $_POST['cboexamen'];
} else {
    $examen = $_POST['cboexamen'];
}

$estado = $_POST['estado'];


$sqlbusca = "SELECT * FROM ORDENLABDETALLE WHERE NRO_ORDEN='$nroorden' AND ID_EXAMEN=$examen";
$consulta = $ConexionDB->query($sqlbusca);
$rpta = $consulta->fetchColumn();

if (empty($rpta)) {
    $sql = "INSERT INTO 
    ORDENLABDETALLE (Nro_orden, NroordenLab, Id_Examen) 
    VALUE (?,?,?)";
    $consulta = $ConexionDB->prepare($sql);
    $resultado = $consulta->execute([$nroorden, $nroordenlab, $examen]);

    $sql1 = "SELECT  COUNT(Nro_orden) FROM ORDENLABDETALLE WHERE NRO_ORDEN='$nroorden'";
    $consulta = $ConexionDB->query($sql1);
    $nro = $consulta->fetchColumn();

    $sql = "UPDATE
            ORDENLAB
            SET registros=?
            WHERE  Nro_orden=?";
    $consulta = $ConexionDB->prepare($sql);
    $resultado = $consulta->execute([$nro, $nroorden]);


    /*
    $sqlexam = "SELECT count(Id_Examen) FROM examsubcat where Id_examen='$idexamen'";
$consulta = $ConexionDB->query($sqlexam);
$cant = $consulta->fetchColumn();

    
    $sqlexam = "SELECT * FROM examsubcat where Id_Examen='$row->Id_Examen'";

    $sql = "INSERT INTO ORDENLABSUBDET (Nro_detalle, id_examen,id_examsubcat, resultado, fecha) 
            VALUE (?,?,?,?,?)";
    $inserta = $ConexionDB->prepare($sql);
    $guarda = $inserta->execute([$resultado, $muestrauno, $nro_detalle, $idexamen, $id]);*/

    if ($resultado) {
        header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $nroorden . '&estado=' . $estado);
        exit();
    } else {
        echo "NO se han insertado los datos";
        return;
    }
} else {
    header('Location: ../Views/ordenlabviews.php?Nro_orden=' . $nroorden . '&estado=' . $estado);
}
