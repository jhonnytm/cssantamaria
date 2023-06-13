<?php
session_start();
if (isset($_SESSION['nombre'])) {
    header('location:./Views/bienvenida.php');
}
?>

<div class="container">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
            <span> <img src="Public/images/logotipo.png" class="w-75" alt="Logo"> </span><br />
            <span class="logo_title mt-5"> Sistema de Atención al Paciente</span>
        </div>
        <div class="card-body">
            <form id="login" method="post" action="Models/M_login.php">

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="txtusuario" id="txtusuario" class="form-control" placeholder="Nombre de usuario" required>
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="txtcontrasena" id="txtcontrasena" class="form-control" placeholder="Ingrese su password" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="ingresar" value="Ingresar" class="form-control">
                </div>

            </form>
        </div>
    </div>
</div>