<?php
session_start();
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

$idhorario = $_POST['horario'];
$orden = $_POST['Nro_orden'];

if (empty($_POST['txthc']) && empty($_POST['txtdni'])) {
    header('location: ../views/citapaciente2.php?Nro=' . $idhorario . '&Nro_orden=' . $orden);
    exit();
} else {
    $hc = $_POST['txthc'];
}
$sqlseguro = "SELECT id_condseguro from ordenlab where Nro_orden='$orden'";
$consultaseguro = $ConexionDB->query($sqlseguro);
$conseguro = $consultaseguro->fetchColumn();

$longitud = 8;
$paciente = substr(str_repeat(0, $longitud) . $hc, -$longitud);

$sqlhc = "SELECT * FROM HISTCLINICA where Nro_HC='$paciente'";
$consultahc = $ConexionDB->query($sqlhc);
$registrohc = $consultahc->fetchAll(PDO::FETCH_OBJ);

foreach ($registrohc as $row) :
    $nrohc = $row->Nro_HC;
    $tipodoc = $row->ID_Tipodoc;
    $nrodoc = $row->NroDoc;
    $nombres = $row->Nombres;
    $sexo = $row->Sexo_Hc;
endforeach;

if (empty($nrohc)) {
    header('location: ../views/citapaciente2.php?Nro=' . $idhorario . '&Nro_orden=' . $orden . '&hc=' . $hc);
    die();
}
$sql2 = "SELECT * from CITAS WHERE Id_horario='$idhorario' and Nro_HC='$paciente'";
$consulta2 = $ConexionDB->query($sql2);
$citas = $consulta2->fetchColumn(PDO::FETCH_OBJ);

if (!empty($citas)) {
    header('location: ../views/citapaciente2.php?Nro=' . $idhorario . '&Nro_orden=' . $orden . '&hc=' . $hc);
    die();
}

$sql = "SELECT count(*) from CITAS WHERE Id_horario='$idhorario'";
$cant = $ConexionDB->query($sql);
$total = $cant->fetchColumn();
$numerocupo = $total + 1;

$sql4 = "SELECT * FROM TURNOsXDIA WHERE Id_horario='$idhorario'";
$consulta4 = $ConexionDB->prepare($sql4);
$consulta4->execute();
$turnosxdia = $consulta4->fetchAll(PDO::FETCH_OBJ);
foreach ($turnosxdia as $row) :
    $idturno = $row->Id_Turno;
    $cuposdispo = $row->NroCupos;
    $adic = $row->Adicionales;
    $idcartera = $row->Id_cartera;
    $nrolargo = $row->Nro;
    $fechacita = $row->Fecha;
endforeach;

/*$sqlseguro = "SELECT id_condseguro from ordenlab where Nro_orden='$orden'";
$consultaseguro = $ConexionDB->query($sqlseguro);
$conseguro = $consultaseguro->fetchColumn();*/

$sql5 = "SELECT cupos FROM carteracupos WHERE Id_cartera='$idcartera'";
$consulta5 = $ConexionDB->query($sql5);
$cupos = $consulta5->fetchColumn();

$sql6 = "SELECT HORAINICIO_TURNO FROM TURNOS WHERE id_turno='$idturno'";
$consulta6 = $ConexionDB->query($sql6);
$horainicial = $consulta6->fetchColumn();

$sql7 = "SELECT minxturno FROM CARTERASERV WHERE id_cartera='$idcartera'";
$consulta7 = $ConexionDB->query($sql7);
$minutos = $consulta7->fetchColumn();

$segundos = strtotime($horainicial);
$segundosmin = ($minutos * 60) * $numerocupo;
$horainicio = date("H:i:s", $segundos + $segundosmin);

$segundosfin = strtotime($horainicio);
$segundosminfin = $minutos * 60;
$horafinal = date("H:i:s", $segundosfin + $segundosminfin);

if (empty($conseguro)) {
    $conseguro = '1';
}
$sql8 = "INSERT INTO 
                citas (Id_horario, Nro_HC, orden, horainicio, horafin, Id_conseguro) 
                VALUE (?,?,?,?,?,?)";
$consulta8 = $ConexionDB->prepare($sql8);
$resultado = $consulta8->execute([$idhorario, $paciente, $numerocupo, $horainicio, $horafinal, $conseguro]);
//$orden = $row->lastInsertId();

$nuevocupo = $cupos - $numerocupo;

$sqlcita = "UPDATE ORDENLAB SET FechaCita=?  WHERE Nro_orden=?";
$consultacita = $ConexionDB->prepare($sqlcita);
$consultacita->execute([
    $fechacita, $orden
]);

$iduser = $_SESSION['iduser'];
$sql9 = "UPDATE TURNOSXDIA SET NroCupos=?, id_usuario=? WHERE Id_horario=?";
$consulta9 = $ConexionDB->prepare($sql9);
$consulta9->execute([$nuevocupo, $iduser, $idhorario]);

$sql2 = "SELECT * from CITAS WHERE Id_horario='$idhorario' and Nro_HC='$paciente'";
$consulta2 = $ConexionDB->query($sql2);
$citas = $consulta2->fetchAll(PDO::FETCH_OBJ);
foreach ($citas as $row) :
    $cita = $row->Nro_Cita;
    $citass = $cita + 1;
endforeach;

/*if ($resultado) {
    $sql = "SELECT * FROM TURNOXDIA WHERE Id_horario='$idhorario'";
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute();
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);

    foreach ($registro as $row) :
        $cartera = $row->desc_cartera;
        $consultorio = $row->desc_consultorio;
        $prof = $row->Nombres_Prof;
        $fecha = $row->Fecha;
        $turno = $row->desc_turno;
    endforeach;
}*/
if ($resultado) {
    header('location: ../views/citaview2.php?horario=' . $idhorario . '&hc=' . $hc . '&cita=' . $cita);
    //header('location: ../views/citaconfirmada.php?horario=' . $idhorario . '&cita=' . $cita);
} else {
    echo "No se insertaron ";
}
