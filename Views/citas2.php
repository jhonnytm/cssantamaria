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
        die();
    }
    ?>
</div>
<div class="container">
    <?php
    $fecha = date('Y-m-d');
    $sql = "SELECT * FROM turnoxdia WHERE FECHA >='$fecha' ORDER BY FECHA ASC";

    if (isset($_POST['buscar'])) {
        $mifecha = $_POST['fechacita'];
        $sql = "SELECT * FROM TURNOXDIA WHERE FECHA='$mifecha'";
    } else {
    }
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute();
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);

    if (empty($_GET['hc'])) {
        $hc = "";
    } else {
        $hc = $_GET['hc'];
    }
    if (empty($_GET['estado'])) {
        $estado = "";
    } else {
        $estado = $_GET['estado'];
    }
    if (empty($_GET['Nro_orden'])) {
        $orden = "";
    } else {
        $orden = $_GET['Nro_orden'];
    }


    ?>
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Turnos programados </b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <strong>
                <input type=hidden value="<?php echo $orden ?>">
                <?php echo "Hoy es : " . date('Y-m-d') ?>
                <?php

                /*   /* $sqlhc = "SELECT * FROM HISTCLINICA WHERE NRO_HC='$hc'";
    $consultahc = $ConexionDB->query($sqlhc);
    //$consultahc->execute();
    $registrohc=$consultahc->fetchColumn;
    $registrohc = $consultahc->fetchAll(PDO::FETCH_OBJ);

                foreach ($registrohc as $reghc) :
        echo "Historia Clínica : <b> " . $hc . '</b>';
        //echo "Nro de Doc : <b> " . $reg->NroDoc . '</b>';
        echo "Paciente : <b> " . $reghc->Nombres . '</b><br>';
            endforeach;*/
                ?>
                <!--<input type=text value="<?php echo $hc ?>"></strong>-->
                <hr>
                <!--<form name="Citas" method="GET" action="citas2.php?hc=<?php echo $hc ?>">
                    <div class="input-group forgroup">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-2">
                            <label>Seleccione Fecha : </label>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="fechacita" class="form-control" placeholder="Fecha" required>
                        </div>
                        <div class="col-md-2">
                            <input type=text value="<?php echo $hc ?>">
                        </div>
                        <div class="col-md-2">
                            <button type=submit name="buscar" class="btn btn-outline-info">...</button>
                        </div>

                    </div><br>
                </form>-->
                <hr>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Consultorio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Profesional</th>
                                    <th scope="col">Turno</th>
                                    <th scope="col">Libres</th>
                                    <th scope="col">Extras</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($registro as $row) : ?>
                                    <th scope="row"><?php echo $row->desc_consultorio ?></th>
                                    <td><?php echo $row->Fecha ?></td>
                                    <td><?php echo $row->Nombres_Prof ?></td>
                                    <td><?php
                                        if (($row->desc_turno) == "Tarde") {
                                            echo '<font color=gray>' . $row->desc_turno . '</font>';
                                        } else {
                                            echo '<font color=blue>' . $row->desc_turno . '</font>';
                                        } //echo $row->desc_turno 
                                        ?>
                                    </td>
                                    <td><?php
                                        if (($row->NroCupos) <= 0) {
                                            echo '<font color=red>' . $row->NroCupos . '</font>';
                                        } else {
                                            echo '<font color=black>' . $row->NroCupos . '</font>';
                                        }
                                        //echo $row->NroCupos 
                                        ?></td>
                                    <td><?php echo $row->adicionales ?></td>
                                    <td>
                                        <!--<form action="citapaciente2.php" method=post>

                                            <input type text="" name="Nro" value="<?php echo $row->Id_horario ?>">
                                            <input type text="" name="hc" value="<?php echo $hc ?>">
                                            <input type text="" name="Nro_orden" value="<?php echo $orden ?>">
                                            <button type=submit>Enviar a</button>
                                        </form>-->
                                        <a class="btn btn-outline-success" role="button" href="citapaciente2.php?Nro=<?php echo $row->Id_horario ?>&hc=<?php echo $hc ?>&Nro_orden=<?php echo $orden ?>">Reservar Cita</a>
                                    </td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
        </div>
    </div>
</div>

<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>