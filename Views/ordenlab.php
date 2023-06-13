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
    }
    ?>
</div>
<div class="container">
    <?php
    $fechaactual = date('Y-m-d');

    $sql = "SELECT * FROM ordenhistprof where FechaCita='$fechaactual' order by Fechacita desc limit 25";

    if (isset($_POST['buscar'])) {
        $apepat = $_POST['txtapellidos'];
        $doc = $_POST['txtdni'];
        $hc = $_POST['txthc'];

        $longitud = 8;
        $nrohc = substr(str_repeat(0, $longitud) . $hc, -$longitud);

        if (($apepat == "") && ($doc == "") && ($hc == "")) {
            $condicion = "";
        } elseif (!empty($apepat)) {
            $condicion = "WHERE Paciente like '%" . $apepat . "%'";
        } elseif (!empty($doc)) {
            $condicion = "WHERE NroDoc ='" . $doc . "'";
        } else {
            $condicion = "WHERE Nro_HC ='" . $nrohc . "'";
        }
        $sql = " SELECT * FROM ordenhistprof " . $condicion . " order by Fechacita desc limit 25";
    }

    $consulta = $ConexionDB->query($sql);
    $fila = $consulta->fetchAll(PDO::FETCH_OBJ);

    ?>
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Órdenes de Laboratorio</b>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?><strong></div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <form name=histclinica method="post" action="ordenlab.php">
                <div class="input-group forgroup">
                    <div class="col-md-1">
                        <a href="ordenlabnew2.php" class="btn btn-outline-primary">Nuevo</a>
                    </div>
                    <div class="col-md-11">
                    </div>
                </div>
                <hr>
                <div class="input-group form-group ">
                    <div class="col-md-7">
                        <input type="text" name="txtapellidos" class="form-control" placeholder="Apellidos">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="txtdni" class="form-control" placeholder="Nro de Documento">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="txthc" class="form-control" placeholder="Historia clínica">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" name="buscar" class="btn btn-outline-success">Buscar</button>
                    </div>
                </div>
                <hr>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Fecha Orden</th>
                            <th scope="col">Fecha Citada</th>
                            <th scope="col">Nro Hist Clínica</th>
                            <th scope="col">Paciente</th>
                            <th scope="col">Profesional</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($ConexionDB)) :
                            //$sql = $ConexionDB->query("SELECT Nro_orden, NroOrdenLab, FechaEmision, Nro_HC,  Paciente, Nombres_Prof, Estado FROM ordenhistprof order by Nro_orden desc limit 15");
                            //$fila = $sql->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) {
                                //foreach ($datos as $key => $value) :
                                //foreach ($value as $v) : 
                        ?>
                                <tr>
                                    <!--<th scope="row"><//?php echo $row->Nro_orden ?></th>-->
                                    <!--<th scope="row"><//?php echo $row->FechaCita ?></th>-->
                                    <td><?php echo $row->FechaEmision ?></td>
                                    <td><?php echo $row->FechaCita ?></td>
                                    <td><?php echo $row->Nro_HC ?></td>
                                    <td><?php echo $row->Paciente ?></td>
                                    <td><?php echo $row->Nombres_Prof ?></td>
                                    <td><?php if (($row->Estado) === "PENDIENTE") {
                                            echo '<font color=red>' . $row->Estado . '</font>';
                                        } else {
                                            echo '<font color=blue>' . $row->Estado . '</font>';
                                        } ?></td>
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