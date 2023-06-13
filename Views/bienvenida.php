<div class="header">
	<?php
	session_start();

	include_once('menu/header.php');

	if (!isset($_SESSION['nombre'])) {
		header('Location: ../index.php');
	} elseif (isset($_SESSION['nombre']) || isset(($_SESSION['rol']))) {
		include_once('menu/menu.php');
		include_once('../Config/Conexion2.php');

		$sql = "SELECT * FROM CONFIGURACION WHERE ID_EESS='5625'";
		$consulta = $ConexionDB->prepare($sql);
		$consulta->execute();
		$registro = $consulta->fetchAll(PDO::FETCH_OBJ);
		foreach ($registro as $row) :
			$eess = $row->Nombre_EESS;
			$dire = $row->Direccion_EESS;
			$telef = $row->Telef_EESS;
			$celular = $row->Celular_EESS;
			$email = $row->Email_EESS;
		endforeach;
	} else {
		echo "Error en el sistema";
	}


	?>
</div>
<div class="container">
	<div class="input-group form-group">
		<div class="input-group form-group">
			<div class=col-md-4></div>
			<div class=col-md-6></div>
			<div class=col-md-2></div>
		</div>
	</div>
	<div class="card card-5">

		<div class="card-body">
			<div class="input-group form-group">
				<div class=col-md-2>Bienvenido :</div>
				<div class=col-md-6><b><?php echo ($_SESSION['nombre']) ?></b></div>
				<div class=col-md-4>

				</div>
			</div>
			<div class="input-group form-group">
				<div class=col-md-2>Establecimiento :</div>
				<div class=col-md-6><b><?php echo $eess ?></b></div>
				<div class=col-md-4>
				</div>
			</div>
			<div class="input-group form-group">
				<div class=col-md-2>Dirección:</div>
				<div class=col-md-6><b><?php echo $dire ?></b></div>
				<div class=col-md-4>
				</div>
			</div>
			<div class="input-group form-group">
				<div class=col-md-2>Correo :</div>
				<div class=col-md-6><b><?php echo $email ?></b></div>
				<div class=col-md-4>
				</div>
			</div>
			<div class="input-group form-group">
				<div class=col-md-2>Celular:</div>
				<div class=col-md-2><b><?php echo $celular ?></b></div>
				<div class=col-md-2>Teléfono :</div>
				<div class=col-md-2><b><?php echo $telef ?></b></div>
				<div class=col-md-4>último acceso :<?php echo ($_SESSION['fechault'])	 ?></div>
			</div>

		</div>
	</div>
</div>
<?


?>
</div>
<div class="footer" id="footer">
	<?php include_once('menu/footer.php'); ?>
</div>