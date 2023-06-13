<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
use function PHPUnit\Framework\isNull;

include_once('../Config/Conexion2.php');

//if (isset($_POST['Nro_HC'])) {
if (empty($_POST['txthc']) || empty($_POST['txtNrodoc'])) {
    header('Location: ../Views/hcnuevo.php');
    die();
} else {
}
$HC = $_POST['txthc'];
//if (empty($HC)) {
/*$sql = "SELECT COUNT(*) FROM HISTORIACLINICA";
    $cant = $ConexionDB->query($sql);
    $total = $cant->fetchColumn();
    $nro = $total + 1;*/

$longitud = 8;
$NroHC = substr(str_repeat(0, $longitud) . $HC, -$longitud);

$sqlbusca = "SELECT * FROM HISTORIACLINICA WHERE NRO_HC='$NroHC'";
$resultado = $ConexionDB->query($sqlbusca);
$registro = $resultado->fetchAll(PDO::FETCH_OBJ);
foreach ($registro as $r) :
    $hc = $r->Nro_HC;
endforeach;
//echo $hc;
if (empty($hc)) {

    //echo " " . $tipodoc = $_POST['cbotipodoc'];
    $NroDoc = $_POST['txtNrodoc'];
    $Apepat = strtoupper($_POST['txtapepat']);
    $Apemat = strtoupper($_POST['txtapemat']);
    $nombres = strtoupper($_POST['txtnombres']);
    //$estadociv = $_POST['cboestadocivil'];
    $genero = $_POST['cbogenero'];
    //$seguro = $_POST['cbocondseguro'];
    //$etnia = $_POST['cboetnia'];
    //$Telefono = $_POST['txttelefono'];
    $Celular = $_POST['txtcelular'];
    $Direccion = strtoupper($_POST['txtdireccion']);
    //$dpto = $_POST['cbodpto'];
    $mifecha = date('Y-m-d H:i:s');
    $fecnac=$_POST['txtfechanac'];
    $estado = "ACTIVO";

    $sql = "INSERT INTO 
            HISTORIACLINICA (Nro_HC, NroDoc, Apepat_HC, Apemat_HC, Nombres_HC, Sexo_HC, FechaNac_HC, Celular_HC, 
            Direccion_HC, Estado, FechaIns_HC) 
            VALUE (?,?,?,?,?,?,?,?,?,?,?)";
    $consulta = $ConexionDB->prepare($sql);
    $resultado = $consulta->execute([$NroHC, $NroDoc, $Apepat, $Apemat, $nombres, $genero, $fecnac, $Celular, $Direccion,  $estado, $mifecha]);

    if ($resultado) {
        header('Location: ../Views/hc.php');
        exit();
    } else {
        $correcto = false;
        echo "NO se han insertado los datos";
        return;
    }
} else {
    header('Location: ../Views/hcnuevo.php');
    die();
};
/*

    
    //if (empty($HC)) {

    // }
} else {
    $NroHC = $HC;
    //echo "  " . $tipodoc = $_POST['cbotipodoc'];
    $NroDoc = $_POST['txtNrodoc'];
    $Apepat = strtoupper($_POST['txtapepat']);
    $Apemat = strtoupper($_POST['txtapemat']);
    $nombres = strtoupper($_POST['txtnombres']);
    $estadociv = $_POST['cboestadocivil'];
    $genero = $_POST['cbogenero'];
    $seguro = $_POST['cbocondseguro'];
    $etnia = $_POST['cboetnia'];
    $Telefono = $_POST['txttelefono'];
    $Celular = $_POST['txtcelular'];
    $Direccion = strtoupper($_POST['txtdireccion']);
    $dpto = $_POST['cbodpto'];
    $mifecha = date('Y-m-d H:i:s');
    $estado = "ACTIVO";
    $sql = "UPDATE 
            HISTORIACLINICA 
            SET 
            NroDoc=?, Apepat_HC=?, Apemat_HC=?, Nombres_HC=?, Sexo_HC=?, Telef_HC=?, Celular_HC=?, 
            Direccion_HC=?, EstadoCivil=?, Id_CondSeguro=?, Id_Etnia=?, Id_Dpto=?, Estado=?, FechaEdit_HC=? 
            WHERE Nro_HC=?";
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute([
        $NroDoc, $Apepat, $Apemat, $nombres, $genero, $Telefono, $Celular,
        $Direccion, $estadociv, $seguro, $etnia, $dpto, $estado, $mifecha, $NroHC
    ]);
    if ($consulta) {
        //echo 'swal("Good job!", "You clicked the button!", "success")';
        $correcto = true;
        header('Location: ../Views/hc.php');
    } else {
        echo "NO se han insertado los datos";
        $correcto = false;
    }
}*/
