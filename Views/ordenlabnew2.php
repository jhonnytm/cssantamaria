<div class="header">
    <?php
    session_start();

    include_once('menu/header.php');

    if (!isset($_SESSION['nombre'])) {
        header('Location: ../index.php');
    } elseif (isset($_SESSION['nombre'])) {
        include_once('menu/menu.php');
        include_once('../Config/Conexion2.php');
    } else {
        echo "Error en el sistema";
        die();
    }
    ?>

</div>
<div class="container">
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Generar Orden de Laboratorio</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <form name="ordenlab" method="POST" action="../Models/M_ordenlabnew2.php">
                <strong>Datos del paciente :</strong>
                <div class="input-group forgroup">
                    <div class="col-md-3">
                        <label>HC u otro documento :</label>
                    </div>
                    <div class="col-md-3">
                        <input type=Text name="nrohc" class="form-control" placeholder="Historia Clínica">
                    </div>
                    <div class="col-md-1">
                        <strong>O</strong>
                    </div>
                    <div class="col-md-3">
                        <input type=Text name="nrodoc" class="form-control" placeholder="Nro de Documento">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" name="agregarexamen" value="Agregar" class="btn btn-outline-success my-2 my-sm-0">Buscar paciente</button>
                    </div>
                </div>
                <hr>
                <div class="input-group forgroup">
                    <div class="col-md-2">
                        <a class="btn btn-info" role="button" href="../Views/ordenlab.php">Regresar</a>
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-2">

                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class=footer id footer>
        <?php include_once('menu/footer.php'); ?>
    </div>