<div id="header">
    <?php

    use Psy\Readline\Hoa\Ustring;

    $rol = $_SESSION['rol'];
    if ((strtoupper($rol) === "ADMINISTRADOR") || strtoupper($rol) === "ROOT") {
    ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#"><img src="../Public/images/logotipo.png" class="w-75" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="bienvenida.php">Inicio <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admisión
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="hc.php">Pacientes</a>
                            <a class="dropdown-item" href="citas.php">Citas</a>
                            <a class="dropdown-item" href="citasdelpaciente.php">Buscar citado</a>
                            <div class="dropdown-divider"></div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Laboratorio
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="ordenlabnew2.php">Ingresar Orden</a>
                            <a class="dropdown-item" href="ordenlab.php">Ingresar Resultados</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="ordenlab2.php">Órdenes Finalizadas</a>
                            <a class="dropdown-item" href="muestrasxfecha.php">Muestras por fecha </a>
                            <a class="dropdown-item" href="ordenlabexamenes.php">Exámenes realizados </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Programación</a>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="turnosxdia.php">Programación de Turnos</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="profesionales.php">Profesionales</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Configuración
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="eess.php">EESS</a>
                            <a class="dropdown-item" href="cartera.php">Cartera de Servicios</a>
                            <a class="dropdown-item" href="consultorios.php">Consultorios</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="usuarios.php">Usuarios</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#"><?php echo $rol ?></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="logout.php">&nbsp; &nbsp; Salir &nbsp;&nbsp; </a>
                        </li>
                    </ul>
                </form>
            </div>
        </nav>
</div>

<?php
    } else {
?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><img src="../Public/images/logotipo.png" class="w-75" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="bienvenida.php">Inicio <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admisión
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="hc.php">Pacientes</a>
                        <a class="dropdown-item" href="citas.php">Citas</a>
                        <a class="dropdown-item" href="citasdelpaciente.php">Buscar citado</a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Laboratorio
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="ordenlabnew2.php">Ingresar Orden</a>
                        <a class="dropdown-item" href="ordenlab.php">Ingresar Resultados</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="ordenlab2.php">Órdenes Finalizadas</a>
                        <a class="dropdown-item" href="muestrasxfecha.php">Muestras por fecha </a>
                        <a class="dropdown-item" href="ordenlabexamenes.php">Exámenes realizados </a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><?php echo $rol ?></a>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php">&nbsp; &nbsp; Salir &nbsp;&nbsp; </a>
                    </li>
                </ul>
            </form>
        </div>
    </nav>
    </div>
<?php

    }
?>