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
        die();
    }
    ?>
</div>

<div class="container">
    <?php
    $fecha = date('Y-m-d');
    $sql = "SELECT * FROM TURNOxDIA WHERE FECHA='$fecha%'";

    if (isset($_POST['buscar'])) {
        $mifecha = $_POST['fechita'];
        $sql = "SELECT * FROM TURNOXDIA WHERE FECHA  ='$mifecha'";
    } else {
    }
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute();
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);

    ?>
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Asignación de turnos</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">

            <form id="ProgTurno" name="ProgTurno" method="post" action="turnosxdia2.php">
                <div class="input-group forgroup">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-4">
                        <label><strong> Seleccione Fecha :</strong> </label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-8">

                        <label>Seleccione Cartera de Servicio : </label>
                        <select class="custom-select mr-sm-2 form-control" name="cbocartera" id="cbocartera">
                            <option selected value="0">Cartera de Servicio</option>
                            <?php
                            $sql = " SELECT * FROM CARTERASERV";
                            $consulta = $ConexionDB->query($sql);
                            $fila = $consulta->fetchAll(PDO::FETCH_OBJ); ?>
                            <?php
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_Cartera . '">' . $row->Desc_Cartera . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <button type="submit" name="guardar" value="Agregar" class="btn btn-outline-primary">Agregar</button>
                </div>
            </form>
        </div>
        <div class="footer" id="footer">
            <?php include_once('menu/footer.php'); ?>
        </div>