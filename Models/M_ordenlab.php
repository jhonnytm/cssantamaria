<?php
include_once('../Config/Conexion2.php');

$nroordenlab = $_POST['nroordenlab'];
$sql = "SELECT COUNT(*) FROM ORDENLABTEMP";
$consulta = $ConexionDB->query($sql);
$total = $consulta->fetchColumn();
$nro = $total + 1;

//$consulta->execute();
//$registro=$consulta->fetchAll(PDO::FETCH_OBJ);

//echo $nroorden = $_POST['Nroorden'];
$fechaactual = date('Y-m-d H:i:s');
$nrodoc = $_POST['nrodoc'];
$fechaemision = $_POST['fechaemitida'];
$prof = $_POST['prof'];
$estrategia = $_POST['estrategia'];
$seguro = $_POST['seguro'];
$estado = $_POST['estado'];
$fecharegistro = $fechaactual;

//DETALLEORDEN
$examen = $_POST['cboexamen'];
$muestrauno = $_POST['fecharegistro'];
$resultadouno = $_POST['resultadoexamen'];
/*$dosmuestra = $_POST['Nroorden'];
$resultado2 = $_POST['Nroorden'];
$tresmuestra = $_POST['Nroorden'];
$resultado3 = $_POST['Nroorden'];*/
$sql = "INSERT INTO 
ORDENLABTEMP (Nro_orden, NroOrdenLab, Nro_HC, FechaEmision, Id_Prof, Id_EstrategiaS, Id_CondSeguro, Id_Examen, estado, FechaRegistro, muestra_uno, resultado_uno) 
VALUE (?,?,?,?,?,?,?,?,?,?,?,?)";
$consulta = $ConexionDB->prepare($sql);
$resultado = $consulta->execute([
    $nro, $nroordenlab, $nrodoc, $fechaactual, $prof, $estrategia, $seguro, $examen, $estado, $fecharegistro, $muestrauno, $resultadouno
]);
if ($resultado) {
    $correcto = true;
    header('Location: ../Views/ordenlabreg2.php');
    exit();
} else {
    $correcto = false;
    echo "NO se han insertado los datos";
    return;
}
