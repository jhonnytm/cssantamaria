<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
require_once("C_usuario.php");
$obj = new HomeController();

echo $usuario = $_POST['txtusuario'];
echo $contrasena = $_POST['txtcontrasena'];
echo $repitecontrasena = $_POST['txtrepitecontrasena'];
echo $email = $_POST['txtemail'];
$error = "";
if (empty($usuario) || empty($contrasena) || empty($repitecontrasena)) {
    $error .= "<li>Completa los campos</li>";
    header("Location:usuarios.php?error=" . $error . "&&txtusuario=" . $usuario . "&&txtcontrasena=" . $contrasena .
        "&&txtrepitecontrasena=" . $repitecontrasena . "&&txtemail=" . $email);
} else if ($email && $usuario && $contraena && $repitecontrasena) {
    if ($contrasena == $repitecontrasena) {
        if ($obj->guardarUsuario($usuario, $contrasena, $email) == false) {
            $error .= "<li>El nombre de usuario ya se encuentra en la BD</li>";
            header("Location:usuarios.php?error=" . $error . "&&txtusuario=" . $usuario . "&&txtcontrasena=" . $contrasena .
                "&&txtrepitecontrasena=" . $repitecontrasena . "&&txtemail=" . $email);
        } else {
            header("Location:../index.php");
        }
    } else {
        $error = "<li>Completa los campos</li>";
        header("Location:usuarios.php?error=" . $error . "&&txtusuario=" . $usuario . "&&txtcontrasena=" . $contrasena .
            "&&txtrepitecontrasena=" . $repitecontrasena . "&&txtemail=" . $email);
    }
}
