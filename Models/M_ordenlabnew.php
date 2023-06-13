<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');
session_start();
$usuario = $_SESSION['usuario'];
$id = $_SESSION['idusu'];

$fechaactual = date('Ymd');
$fechafiltro = date('Y-m-d');
$mifecha = date('Y-m-d H:i:s');

if (empty($_POST['cboprof']) || empty($_POST['cboestrategia']) || empty($_POST['cbocondseguro'])) {
    header('Location: ../Views/ordenlabnew.php');
    die();
}

$hc = $_POST['nrohc'];
$doc = $_POST['nrodoc'];

if (empty($_POST['nrodoc']) and empty($_POST['nrohc'])) {

    header('Location: ../Views/ordenlabnew.php');
    exit();
} elseif (!empty($_POST['nrohc'])) {
    $longitud = 8;
    $nrohc = substr(str_repeat(0, $longitud) . $hc, -$longitud);
    $condicion = " WHERE NRO_HC";
} else {
    $longitud = 8;
    $nrohc = substr(str_repeat(0, $longitud) . $doc, -$longitud);
    $condicion = " WHERE NRODOC";
}

$sqlbusca = "SELECT * FROM HISTCLINICA " . $condicion . "='$nrohc'";
//echo $sqlbusca;
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

    $sql = "INSERT INTO ORDENLAB (Nroordenlab, Nro_HC, FechaEmision, Id_Prof, Id_EstrategiaS, Id_usuario, Id_CondSeguro, nrorecibofua, Fecharegistro, estado, impreso) 
    VALUE (?,?,?,?,?,?,?,?,?,?,?)";
    $sql = $ConexionDB->prepare($sql);
    $resultado = $sql->execute([$nroordenlab, $nrohc,  $fechaemision, $prof, $usuario, $estrategia, $seguro, $nrorecibofua, $mifecha, $estado, $impreso]);
    $orden = $ConexionDB->lastInsertId();

    if ($resultado) {
        header('Location: ../Views/ordenlabview.php?Nro_orden=' . $orden . '&estado=' . $estado);
    } else {
        header('Location: ../Views/ordenlabnew.php');
    }
}
