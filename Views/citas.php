<div class="header">
    <?php
    session_start();
    date_default_timezone_set("America/Lima"); //Zona horaria de Peru

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
    <?php
    $fecha = date('Y-m-d');
    $sql = "SELECT * FROM TURNOXDIA WHERE FECHA='$fecha'";

    if (isset($_POST['buscar'])) {
        $mifecha = $_POST['fechacita'];
        $sql = "SELECT * FROM TURNOXDIA WHERE FECHA='$mifecha'";
    } else {
    }
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute();
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    ?>
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Citas</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <strong><?php echo "Hoy es: " . date('Y-m-d') ?></strong>
            <hr>
            <form name="Citas" method="post" action="citas.php">

                <div class="input-group forgroup">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
                        <label>Seleccione Fecha : </label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="fechacita" value="<?php echo date('Y-m-d') ?>" class="form-control" placeholder="Fecha" required>
                    </div>
                    <div class="col-md-2">

                        <button type=submit name="buscar" class="btn btn-outline-info">...</button>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div><br>
            </form>
            <hr>
            <div class="col-md-12">
                <form name="Citas" method="post" action="">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Consultorio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Profesional</th>
                                    <th scope="col">Turno</th>
                                    <th scope="col">Cupos</th>
                                    <th scope="col">Adicionales</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                /*$sql = " SELECT * FROM citas";
                            $consulta = $ConexionDB->query($sql);
                            $fila = $consulta->fetchAll(PDO::FETCH_OBJ);*/
                                foreach ($registro as $row) : ?>
                                    <th scope="row"><?php echo $row->desc_consultorio ?></th>
                                    <td><?php echo $row->Fecha ?></td>
                                    <td><?php echo $row->Nombres_Prof ?></td>
                                    <td><?php echo $row->desc_turno ?></td>
                                    <td><?php echo $row->NroCupos ?></td>
                                    <td><?php echo $row->adicionales ?></td>
                                    <td>
                                        <a class="btn btn-outline-success" role="button" href="citapacientebusca.php?nro=<?php echo $row->Id_horario ?>">Citas</a>

                                        <!--<a class="btn btn-danger" role="button" href="../Models/M.php?Nro_Cita=<?php echo $row->nro ?>" onclick="return confirm('Estas seguro?')">Eliminar</a>-->
                                    </td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>