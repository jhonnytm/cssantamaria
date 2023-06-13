<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
include_once('../Config/Conexion2.php');

if (isset($_POST['cboprof'])) {
	//$nombres = $_POST['txtnombres'];
	$usuario = $_POST['txtusuario'];
	$contrasena = $_POST['txtcontrasena'];
	$repcontrasena = $_POST['txtrepitecontrasena'];
	$email = $_POST['txtemail'];
	$nivel = $_POST['cbonivel'];
	$prof = $_POST['cboprof'];
	$campos = array();

	if ($usuario == "") {
		array_push($campos, "El campo de Usuario no debe estra vacío");
	}
	if ($contrasena == "" || strlen($contrasena) < 6) {
		array_push($campos, "El campo Password no debe estar vació ni tener menos de 6 caracteres");
	}
	if (strlen($contrasena) < strlen($repcontrasena) || strlen($contrasena) > strlen($repcontrasena)) {
		array_push($campos, "las contraseñas deben tener la misma longitud");
	}
	if ($contrasena !== $repcontrasena) {
		array_push($campos, "las contraseñas deben ser iguales");
	}
	if ($email == "" || strpos($email, "@") === false) {
		array_push($campos, "Ingrese un email válido");
	}
	if (count($campos) > 0) {
		echo "<div class='error'> ";
		for ($i = 0; $i < count($campos); $i++) {
			echo "<li>" . $campos[$i];
		}

		die();
	} else {
		$Estado = "ACTIVO";
		$visible = "SI";
		$FechaCrea = date('Y-m-d H:i:s');

		$sql = "SELECT * FROM profesionales WHERE Id_prof='$prof'";
		$consulta = $ConexionDB->query($sql);
		$registro = $consulta->fetchAll(PDO::FETCH_OBJ);
		foreach ($registro as $row) :
			$nombresprof = $row->Nombres_Prof;
		endforeach;

		$sqlbusca = "SELECT Id_Prof FROM USUARIOS WHERE Id_prof='$prof'";
		$consult = $ConexionDB->query($sqlbusca);
		$existe = $consult->fetchColumn();

		if (empty($existe)) {
			$sql = "INSERT INTO 
            USUARIOS (Id_prof, Nombres, usuario, contrasena, email, Id_nivel, Estado, FechaCrea, visible) 
            VALUES (?,?,?,?,?,?,?,?,?)";
			$consulta = $ConexionDB->prepare($sql);
			$resultado = $consulta->execute([$prof, $nombresprof, $usuario, $contrasena, $email, $nivel, $Estado, $FechaCrea, $visible]);

			if ($resultado) {
				/*$correcto = true;
                session_start();
                $_SESSION['mensaje'] = " Se ha insertado el usuario";*/
				header('Location: ../Views/bienvenida.php');
			} else {
				/*$correcto = false;
                session_start();
                $_SESSION['mensaje'] = " Error de guardado";*/
				header('Location: ../Views/usuarios.php');
			}
		} else {
			echo "El trabajador ya cuenta con usuario en el sistema";
			exit();
			die();
		}
	}
}
