<?php
session_start();
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

$usuario = $_SESSION['usuario'];
$iduser = $_SESSION['iduser'];

$fechaactual = date('Ymd');
$fechafiltro = date('Y-m-d');
$mifecha = date('Y-m-d H:i:s');

$nrohc = $_POST['nrohc'];
echo $nrohc;
if (empty($_POST['cboprof']) || empty($_POST['cboestrategia']) || empty($_POST['cbocondseguro'])) {
    header('Location: ../views/ordenlabnew3.php?nrohc=' . $nrohc);
    die();
}


$longitud = 8;
$nrohc = substr(str_repeat(0, $longitud) . $nrohc, -$longitud);

$sqlbusca = "SELECT * FROM HISTCLINICA where NRO_HC='$nrohc'";
$consulta = $ConexionDB->query($sqlbusca);
$registro = $consulta->fetchAll(PDO::FETCH_OBJ);

foreach ($registro as $row) :
    $encuentra = $row->Nombres;
endforeach;

if (empty($encuentra)) {
    //header('Location: ../Views/ordenlabnew.php');
    header('Location: ../Views/hcnuevo.php');
    die();
} else {

    $sqlbusca = "SELECT * FROM HISTCLINICA where Nro_hc = $nrohc";
    $sqlbusca;
    $consulta = $ConexionDB->query($sqlbusca);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        echo $encuentra = $row->Nombres;
        echo $sexo = $row->Sexo_Hc;
        echo $nrodoc = $row->NroDoc;
        echo $hc = $row->Nro_HC;
    endforeach;


    $sql = "SELECT COUNT(*) FROM ORDENLAB WHERE date(Fecharegistro)='$fechafiltro'";
    $cant = $ConexionDB->query($sql);
    $total = $cant->fetchColumn();
    $nro = $total + 1;

    $longitud = 4;
    $nroorden = substr(str_repeat(0, $longitud) . $nro, -$longitud);
    $nroordenlab = $fechaactual . $nroorden;

    $fechaemision = $_POST['fechaemision'];
    $prof = $_POST['cboprof'];
    $estrategia = $_POST['cboestrategia'];
    $seguro = $_POST['cbocondseguro'];
    $nrorecibofua = $_POST['nrorecibofua'];
    $estado = "PENDIENTE";
    $impreso = "NO";



    //fecha de cita pendiente:
    $sql = "INSERT INTO ORDENLAB (Nroordenlab, Nro_HC, FechaEmision, Id_Prof,  Id_EstrategiaS, Id_CondSeguro, Id_usuario, nrorecibofua, Fecharegistro, estado, impreso) 
    VALUE (?,?,?,?,?,?,?,?,?,?,?)";
    $sql = $ConexionDB->prepare($sql);
    $resultado = $sql->execute([$nroordenlab, $nrohc,  $fechaemision, $prof, $estrategia, $seguro, $iduser, $nrorecibofua, $mifecha, $estado, $impreso]);
    $orden = $ConexionDB->lastInsertId();

    if ($resultado) {
        header('Location: ../Views/ordenlabview.php?Nro_orden=' . $orden . '&estado=' . $estado);
    } else {
        header('Location: ../Views/ordenlabnew.php');
    }
}
