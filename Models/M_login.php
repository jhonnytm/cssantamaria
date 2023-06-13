<?php
session_start();
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include("../Config/Conexion2.php");

if (empty($_POST['txtusuario']) && empty($_POST['txtcontrasena'])) {
    header("location: ../index.php");
} else {
    $usuario = $_POST['txtusuario'];
    $pass = $_POST['txtcontrasena'];

    $sql = "SELECT * FROM USUARIOS where usuario=? and contrasena=?";
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute([$usuario, $pass]);
    $resultado = $consulta->fetchAll(PDO::FETCH_OBJ);

    $cant = $consulta->rowCount();
    foreach ($resultado as $reg) :
        $nivel = $reg->Id_Nivel;
        $nombres = $reg->Nombres;
        $fechaul = $reg->FechaUltima;
        $id = $reg->Id_Usuario;
        $user = $reg->usuario;
    endforeach;

    $sql2 = "SELECT * FROM NIVEL WHERE ID_NIVEL='$nivel'";
    $consulta2 = $ConexionDB->query($sql2);
    $resultado2 = $consulta2->fetchAll(PDO::FETCH_OBJ);
    foreach ($resultado2 as $row) :
        $rol = $row->Desc_nivel;

    endforeach;

    $fechaactual = date('Y-m-d H:i:s');
    $sql3 = "UPDATE USUARIOS  SET FECHAULTIMA=? WHERE USUARIO=?";
    $consulta3 = $ConexionDB->prepare($sql3);
    $consulta3->execute([
        $fechaactual, $usuario
    ]);

    $_SESSION['nombre'] = $nombres;
    $_SESSION['rol'] = $rol;
    $_SESSION['fechault'] = $fechaul;
    $_SESSION['user'] = $user;
    $_SESSION['iduser'] = $id;
    header("location: ../Views/bienvenida.php");
}
