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
    $sql = "SELECT desc_examen, COUNT(Id_examen) AS Cant  FROM examenesxhc GROUP BY desc_examen";

    if (isset($_POST['buscar'])) {
        $fechaini = $_POST['txtfechaini'];
        $fechafin = $_POST['txtfechafin'];
        //$sql = " SELECT * FROM ordenhistprof where date(FechaCita) between '$fechaini' and '$fechafin' order by Nro_HC desc limit 25";
        //$sql = "SELECT * FROM ordenhistprof where date(Fechatermino) between '$fechaini' and '$fechafin' ORDER BY date(FechaTermino) desc";
        $sql = "SELECT desc_examen, COUNT(Id_examen) AS Cant  FROM examenesxhc WHERE date(FechaTermino) BETWEEN '$fechaini' AND '$fechafin' GROUP BY desc_examen";
    }

    $consulta = $ConexionDB->query($sql);
    $fila = $consulta->fetchAll(PDO::FETCH_OBJ);
    ?>
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Exámenes Realizados</b>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?><strong></div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <form name=histclinica method="post" action="ordenlabexamenes.php">
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
            <form name=detalleorden method="post" action="../muestrasxfechadet.php">
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
                        <!--<button type="submit" name="buscar" class="btn btn-outline-success">Ver Detalle</button>-->
                    </div>
                    <div class="col-md-0">
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <b>Conteo desde : <?php echo $fechaini ?> al : <?php echo $fechafin ?></b>
                <table class="table table-sm">
                    <tr>
                        <th scope="col">Nombre del examen</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Acción</th>
                    </tr>
                    <?php
                    //echo '<table border=1>';
                    /*echo '<tr>';
                    echo '<th scope="col">Nombre del examen</th>';
                    echo '<th scope="col">Cantidad</th>';
                    echo '<th scope="col">Acción</th>';
                    echo '</tr>';*/
                    $sql1 = "SELECT Id_CategExam, COUNT(*) as cant FROM ordenlabexamenes WHERE date(Fechatermino) between '$fechaini' and '$fechafin' group BY ID_categexam ";
                    $consulta = $ConexionDB->query($sql1);
                    $registro = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($registro as $row) :
                        $examentipo = $row['Id_CategExam'];
                        $sql5 = "SELECT * FROM categexamenes WHERE Id_CategExam='$examentipo'";
                        $consulta5 = $ConexionDB->query($sql5);
                        $registro5 = $consulta5->fetchAll(PDO::FETCH_OBJ);
                        foreach ($registro5 as $r) :
                            $nombreexamen = $r->Desc_CategExam;
                        endforeach;
                    ?>
                        <tr>
                            <td colspan=3>
                                <b> <?php echo $nombreexamen ?></b>
                            </td>
                        </tr>
                        <?php
                        $sql2 = "SELECT Desc_examen, COUNT(id_examen) AS cant  from ordenlabexamenes  WHERE date(Fechatermino) between '$fechaini' and '$fechafin' and Id_categExam='$examentipo' GROUP BY Id_examen";
                        //$sql2 = "SELECT desc_examen, COUNT(Id_examen) AS Cant  FROM examenesxhc where nro_orden='655' GROUP BY desc_examen";
                        $consulta2 = $ConexionDB->query($sql2);
                        $registro2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($registro2 as $reg) :
                        ?> <tr>
                                <td><?php echo ' - ' . $reg['Desc_examen'] ?></td>
                                <td><?php echo ' -> ' . $reg['cant'] ?> </td>
                                <!--echo '<td> - ' . $reg['Desc_examen'] . '</td> ';
                            echo '<td>' . $reg['cant'] . '</td><br>';
                            echo '</tr>';-->
                        <?php endforeach;
                    endforeach;
                    //echo '</table>';
                        ?>
                </table>
                <br>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class=footer id footer>
    <?php include_once('menu/footer.php'); ?>
</div>