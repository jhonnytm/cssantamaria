<div class="header">
    <?php
    date_default_timezone_set("America/Lima"); //Zona horaria de Peru
    session_start();

    include_once('menu/header.php');

    if (!isset($_SESSION['nombre'])) {
        header('Location: ../index.php');
    } elseif (isset($_SESSION['nombre'])) {
        include_once('menu/menu.php');
        include_once('../Config/Conexion2.php');
    } else {
        echo "Error en el sistema";
    }
    ?>
</div>
<div class="container">
    <?php
    $fechaactual = date('Y-m-d');
    $sql = "SELECT * FROM ordenhistprof order by Nro_HC desc limit 25";

    if (isset($_POST['buscar'])) {
        $fechaini = $_POST['txtfechaini'];
        $fechafin = $_POST['txtfechafin'];
        //$sql = " SELECT * FROM ordenhistprof where date(FechaCita) between '$fechaini' and '$fechafin' order by Nro_HC desc limit 25";
        $sql = "SELECT * FROM ordenhistprof where date(Fechatermino) between '$fechaini' and '$fechafin' ORDER BY date(FechaTermino) desc";
    }

    $consulta = $ConexionDB->query($sql);
    $fila = $consulta->fetchAll(PDO::FETCH_OBJ);

    ?>

    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Ordenes emitidas para laboratorio</b>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?><strong></div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <form name=histclinica method="post" action="muestrasxfecha.php">
                <div class="input-group form-group ">
                    <div class="col-md-3">
                        <i>Seleccione :</i>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="txtfechaini" class="form-control" value="<?php echo date('Y-m-d')
                                                                                            ?>">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="txtfechafin" class="form-control" value="<?php echo date('Y-m-d')
                                                                                            ?>">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="buscar" class="btn btn-outline-success">Buscar</button>
                    </div>
                </div>
            </form>
            <hr>
            <form name=detalleorden method="post" action="muestrasxfechadet.php">
                <div class="input-group form-group ">
                    <div class="col-md-4">
                        <?php
                        if (empty($fechaini) and empty($fechadin)) {
                            $fechaini = date('Y-m-d');
                            $fechafin = date('Y-m-d');
                        } else {
                            $fechaini = $fechaini;
                            $fechafin = $fechafin;
                        } ?>
                        <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
                        <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
                        <button type="submit" name="buscar" class="btn btn-outline-success">Ver Detalle</button>
                    </div>
                    <div class="col-md-0">
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </form>

            <!--<input type="date" name="txtfechafin" class="form-control" value="<?php echo date('Y-m-d') ?>">-->
            <!--<a class="btn btn-outline-info" type=button href="ordenlabxfechadet.php?fecha=<?php echo date('2023-03-16') ?>">Ver detalle</a>-->
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Fecha Orden</th>
                            <th scope="col">Nro Hist Clínica</th>
                            <th scope="colspan=3">Paciente</th>
                            <th scope="colspan=3">Profesional</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha termino</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($ConexionDB)) :
                            foreach ($fila as $row) {
                        ?>
                                <tr>
                                    <td><?php echo $row->FechaEmision ?></td>
                                    <td><?php echo $row->Nro_HC ?></td>
                                    <td><?php echo $row->Paciente ?></td>
                                    <td><?php echo $row->Nombres_Prof ?></td>
                                    <td><?php if (($row->Estado) === "PENDIENTE") {
                                            echo '<font color=red>' . $row->Estado . '</font>';
                                        } else {
                                            echo '<font color=blue>' . $row->Estado . '</font>';
                                        } ?></td>
                                    <td><?php echo $row->FechaTermino ?></td>
                                    <td>

                                        <a class="btn btn-outline-info" type=button href="ordenlabviews.php?Nro_orden=<?php echo $row->Nro_orden ?>&estado=<?php echo "" ?>">Ver</a>
                                        <!--<a class="btn btn-outline-warning" type=button href="ordenlabview.php?Nro_orden=<?php echo $row->Nro_orden ?>&estado=<?php echo $row->Estado ?>">Edit</a>-->
                                        <!--<a class="btn btn-outline-success" role="button" href="=<?php echo $row->Nro_orden ?>">Imprimir</a>-->
                                        <!--<a class="btn btn-danger" role="button" href="hcnuevo.php?m=eliminar&id=<?php echo $row->Nro_orden ?>" onclick="return confirm('Estas seguro?')">D</a>-->
                                </tr>
                            <?php
                            } //endforeach;
                            //endforeach; 
                            ?>
                        <?php else :
                        ?>
                            <tr>
                                <td> No existen registros</td>
                            </tr>
                        <?php endif
                        ?>

                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class=footer id footer>
    <?php include_once('menu/footer.php'); ?>
</div>