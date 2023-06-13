<?php
include('../Config/Conexion2.php');

$id_cartera = $_POST['Id_Cartera'];

$queryM = "SELECT * FROM consultorios WHERE id_cartera = '$id_cartera'";
$resultadoM = $ConexionDB->query($queryM);
$resultadoM->execute();
$html = "<option value='0'>Seleccionar Municipio</option>";
while ($registro = $resultadoM->fetchAll(PDO::FETCH_ASSOC)) {
    $html .= "<option value='" . $rowM['Id_Consultorio '] . "'>" . $rowM['Desc_consultorio'] . "</option>";
}
echo $html;
