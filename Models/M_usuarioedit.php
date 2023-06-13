<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

$id = $_POST['txtid'];
/*$nombres = $_POST['txtnombres'];
	$usuario = $_POST['txtusuario'];
	$contrasena = $_POST['txtcontrasena'];
	$repcontrasena = $_POST['txtrepitecontrasena'];
	$email = $_POST['txtemail'];*/
$nivel = $_POST['cbonivel'];

$Estado = "ACTIVO";
$visible = "SI";
$FechaCrea = date('Y-m-d H:i:s');

$sql = "UPDATE 
            USUARIOS 
            SET 
            Id_nivel=? 
            WHERE Id_Usuario=?";
$consulta = $ConexionDB->prepare($sql);
$consulta->execute([
	$nivel, $id
]);
if ($consulta) {
	header('Location: ../Views/usuarios.php');
	die();
} else {
}
