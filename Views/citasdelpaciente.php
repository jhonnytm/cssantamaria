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

    $sql = "SELECT * FROM citasdelpaciente order by fecha desc limit 25";
    if (isset($_POST['buscar'])) {
        $hc = $_POST['hc'];
        $longitud = 8;
        $miscitas = substr(str_repeat(0, $longitud) . $hc, -$longitud);
        $sql = "SELECT * FROM citasdelpaciente  WHERE Nro_HC='$miscitas' order by fecha desc limit 25";
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
            <form name="Citas" method="post" action="citasdelpaciente.php">

                <div class="input-group forgroup">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
                        <label>Digite nro de HC: </label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="hc" class="form-control" placeholder="Nro de HC">
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
                                    <th scope="col">Nro_HC</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Consultorio</th>
                                    <th scope="col">Profesional</th>
                                    <th scope="col">Turno</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                /*$sql = " SELECT * FROM citas";
                            $consulta = $ConexionDB->query($sql);
                            $fila = $consulta->fetchAll(PDO::FETCH_OBJ);*/
                                foreach ($registro as $row) : ?>
                                    <th scope="row"><?php echo $row->Nro_HC ?></th>
                                    <td><?php echo $row->Fecha ?></td>
                                    <td><?php echo $row->Desc_consultorio ?></td>
                                    <td><?php echo $row->Nombres_Prof ?></td>
                                    <td><?php echo $row->Desc_turno ?></td>
                                    <td>
                                        <a class="btn btn-outline-success" role="button" href="citasdelpaciente.php?nro=<?php echo $row->Id_horario ?>">Ver Detalle</a>

                                        <a class="btn btn-outline-info" role="button" href="citaconfirmada.php?horario=<?php echo $row->Id_horario ?>&cita=<?php echo $row->Nro_Cita ?>">Ver Cita</a>

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