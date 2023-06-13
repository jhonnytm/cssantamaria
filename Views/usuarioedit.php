<div class="header">
    <?php
    date_default_timezone_set("America/Lima"); //Zona horaria de Peru
    session_start();
    include_once('menu/header.php');

    if (!isset($_SESSION['nombre'])) {
        header:
        ('Location: ../index.php');
    } elseif (isset($_SESSION['nombre'])) {
        include_once('menu/menu.php');
        include_once('../Config/Conexion2.php');
    } else {
        echo "Error en el sistema";
    }
    ?>
    <style>
        .error {
            background-color: #FF9185;
            font-size: 12 px;
            padding: 10px;
        }

        .correcto {
            background-color: #a0dea7;
            font-size: 12px;
            padding: 10px;
        }
    </style>
</div>
<?php

$username = ($_SESSION['nombre']);
$id = ($_SESSION['iduser']);
$nro = ($_GET["iduser"]);

$sqlbusca = "SELECT * FROM USUARIOS WHERE id_usuario='$nro'";
$consultausu = $ConexionDB->query($sqlbusca);
$registros = $consultausu->fetchAll(PDO::FETCH_OBJ);
foreach ($registros as $reg) :
    $id = $reg->Id_Usuario;
    $nombres = $reg->Nombres;
    $usuario = $reg->usuario;
    $email = $reg->email;
    $contrasena = $reg->contrasena;
    $nivel = $reg->Id_Nivel;
    $fechacrea = $reg->FechaCrea;
endforeach;

?>
<div class="container">
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>modificación de rol del usuario</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <form id="Usuarios" action="../Models/M_usuarioedit.php" method="post">
                <?php
                if (isset($_POST['cboprof'])) {
                    $nombres = $_POST['txtnombres'];
                    $usuario = $_POST['txtusuario'];
                    $contrasena = $_POST['txtcontrasena'];
                    $repcontrasena = $_POST['txtrepitecontrasena'];
                    $Email = $_POST['txtemail'];
                    $Nivel = $_POST['cbonivel'];
                    $campos = array();

                    if ($usuario == "") {
                        array_push($campos, "El campo de Usuario no debe estra vacío");
                    }
                    if ($contrasena == "" || strlen($contraena) < 6) {
                        array_push($campos, "El campo Password no debe estar vació ni tener menos de 6 caracteres");
                    }
                    if (strlen($contrasena) < strlen($repcontrasena) || strlen($contrasena) > strlen($repcontrasena)) {
                        array_push($campos, "las contraseñas deben tener la misma longitud");
                    }
                    if ($contrasena !== $repcontrasena) {
                        array_push($campos, "las contraseñas deben ser iguales");
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
                    } else {
                        echo "<div class='correcto'>Datos Correctos";
                    }
                    echo "</div>";
                }
                ?>
                <hr>
                <div class="input-group form-group">
                    <div class=col-md-2>
                        <input type="hidden" name="txtid" id="txtid" class="form-control" value="<?php echo $id ?>" readonly>
                    </div>
                    <div class=col-md-2>
                        Nombres :
                    </div>
                    <div class=col-md-6>
                        <input type="text" name="txtnombres" id="txtnombres" class="form-control" value="<?php echo $nombres ?>" readonly>
                    </div>
                    <div class=col-md-2>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class=col-md-2>
                    </div>
                    <div class=col-md-2>
                        <label>Usuario :</label>
                    </div>
                    <div class=col-md-3>
                        <input type="text" name="txtusuario" id="txtusuario" class="form-control" value="<?php echo $usuario ?>" readonly>
                    </div>
                    <div class=col-md-3>
                    </div>
                    <div class=col-md-2>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class=col-md-2>
                    </div>
                    <div class=col-md-2>
                        <label>Password :</label>
                    </div>
                    <div class=col-md-3>
                        <input type="password" name="txtcontrasena" id="txtcontrasena" class="form-control" value="<?php echo $contrasena ?>" readonly>
                    </div>
                    <div class=col-md-3>
                        <input type="password" name="txtrepitecontrasena" id="txtcontrasena" class="form-control" value="<?php echo $contrasena ?>" readonly>
                    </div>
                    <div class=col-md-2>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class=col-md-2>
                    </div>
                    <div class=col-md-2>
                        <label>E-mail :</label>
                    </div>
                    <div class=col-md-6>
                        <input type="email" name="txtemail" id="txtemail" class="form-control" value="<?php echo $email ?>" readonly>
                    </div>
                    <div class=col-md-2>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class=col-md-2>
                    </div>
                    <div class=col-md-2>
                        <label>Función :</label>
                    </div>
                    <div class=col-md-3>
                        <select class="custom-select mr-sm-2 form-control" name="cbonivel" id="cbonivel">
                            <?php
                            $sql = "SELECT * FROM NIVEL";
                            $consulta = $ConexionDB->prepare($sql);
                            $consulta->execute();
                            $fila = $consulta->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_nivel . '">' . $row->Desc_nivel . '</option>';
                            endforeach; ?>
                        </select>
                    </div>
                    <div class=col-md-1>
                    </div>
                    <div class=col-md-2>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="estado" name="estado" checked>
                            <label for="Estado" class="form-check-label">ACTIVO</label>
                        </div>
                    </div>
                    <div class=col-md-2>
                    </div>
                </div>
                <hr>
                <div class="input-group form-group">
                    <div class=col-md-8> </div>
                    <div class=col-md-2>
                        <input type="submit" name="btn" value="Actualiza rol" class="btn btn-outline-primary">
                    </div>
                    <div class=col-md-2> </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="footer" id=footer>
    <?php include_once('menu/footer.php'); ?></div>
<script src="../Public/js/main.js"></script>