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
    if (isset($_POST['fechaini'])) {
        //echo "bien";
        $fechaini = $_POST['fechaini'];
        $fechafin = $_POST['fechafin'];
        $sql = " SELECT * FROM ordenhistprof where date(Fechatermino) between '$fechaini' and '$fechafin' ORDER BY date(FechaTermino) desc ";
        $consulta = $ConexionDB->query($sql);
        $filas = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($filas as $registro) :
            $nroorden = $registro->Nro_orden;
            $nroordenlab = $registro->NroOrdenLab;
            $fechaemision = $registro->FechaEmision;
            $estado = $registro->Estado;
            $nrodoc = $registro->NroDoc;
            $paciente = $registro->Paciente;
            $seguro = $registro->Desc_Seguro;
            $nrorecibo = $registro->Nrorecibofua;
            $estrategia = $registro->Desc_EstrategiaS;
            $prof = $registro->Nombres_Prof;
            $fechacita = $registro->FechaCita;
            $fechatermino = $registro->FechaTermino;
        endforeach;
    ?>
        <div class="input-group form-group">
            <div class="col-md-5">
                <b>Pacientes citados con muestras de Laboratorio</b>
            </div>
            <div class="col-md-2"> </div>
            <div class="col-md-5"><b><?php echo ($_SESSION['nombre']);
                                        echo $_SESSION['iduser'] ?></b> </div>
        </div>
        <div class="card card-5">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="input-group form-group">
                        <div class="col-md-2">
                            <a class="btn btn-outline-info" type=button href="muestrasxfecha.php">Regresar</a>
                        </div>
                        <div class="col-md-4">
                            Desde :<b> <?php echo $fechaini ?></b>
                        </div>
                        <div class="col-md-4">
                            Hasta: <b><?php echo $fechafin ?></b>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-outline-success" type=button href="../Controllers/C_muestrasxfecha2.php?fechaini=<?php echo $fechaini ?>">Imprimir</a>
                        </div>
                    </div>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Nro orden</th>
                                <th scope="col">Emitido</th>
                                <th scope="col">Citado</th>

                                <th scope="col">Paciente</th>
                                <th scope="col">Profesional</th>
                                <th scope="col">Condicion</th>
                                <th scope="col">Recibo</th>
                                <th scope="col">Estrategia</th>
                                <th scope="col">Finalizado</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Exámenes solicitados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($ConexionDB)) {
                                foreach ($filas as $registro) :
                            ?>
                                    <tr>
                                        <td><?php echo $nroordenn = $registro->Nro_orden
                                            ?>
                                        </td>
                                        <td><?php echo $registro->FechaEmision; ?></td>
                                        <td><?php echo $registro->FechaCita ?></td>

                                        <!--<td><?php //echo $registro->NroDoc 
                                                ?></td>-->
                                        <td><?php echo $registro->Paciente ?></td>
                                        <td><?php echo $registro->Nombres_Prof ?></td>
                                        <td><?php echo $registro->Sigla_Seguro ?></td>
                                        <td><?php echo $registro->Nrorecibofua ?></td>
                                        <td><?php echo $registro->Abrevia_ES ?></td>
                                        <td><?php echo $registro->FechaTermino ?></td>
                                        <td><?php if (($registro->Estado) === "PENDIENTE") {
                                                echo '<font color=red>' . $registro->Estado . '</font>';
                                            } else {
                                                echo '<font color=blue>' . $registro->Estado . '</font>';
                                            } ?></td>
                                        <td><?php
                                            $sqldet = "SELECT * FROM ORDENLABEXAMENES WHERE Nro_orden='$nroordenn'";
                                            $consultdet = $ConexionDB->prepare($sqldet);
                                            $consultdet->execute();
                                            $registrodet = $consultdet->fetchAll(PDO::FETCH_OBJ);
                                            echo '<ol>';
                                            foreach ($registrodet as $filadet) :
                                                echo '<li>' . $filadet->Desc_examen;
                                                echo '->>' . $filadet->Resultado_uno . '<br>';
                                            endforeach;
                                            echo '</ol>';
                                            ?></td>
                                    </tr>
                                <?php
                                endforeach;
                            } else {
                                ?>
                                <tr>
                                    <td> No existen registros</td>
                                </tr>
                            <?php }
                            ?>
                    </table>
                </div>

            <?php
        } else {
            echo "no";
        }
        die();
            ?>
            </div>
        </div>
</div>
<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>