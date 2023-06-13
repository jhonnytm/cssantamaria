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
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Citas</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <?php
            $horario = $_GET['Nro'];
            $orden = $_GET['Nro_orden'];
            $hc = $_GET['hc'];

            $sql = "SELECT * FROM TURNOXDIA WHERE id_horario='$horario'";

            $consulta = $ConexionDB->prepare($sql);
            $consulta->execute();
            $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
            foreach ($registro as $row) {
                echo "Fecha :<b>" . $row->Fecha . '</b>&nbsp;&nbsp';
                $fecha = $row->Fecha;
                echo "Turno :<b>" . $row->desc_turno . '</b><br>';
                echo "Cartera de Servicio :<b>" . $row->desc_cartera . '</b>&nbsp;&nbsp';
                $cartera = $row->desc_cartera;
                echo "Consultorio :<b>" . $row->desc_consultorio . '</b><br>';
                $consultorio = $row->desc_consultorio;
                echo "Profesional :<b>" . $row->Nombres_Prof . '</b><br>';
                $prof = $row->Nombres_Prof;


                echo "Cupos libres :<b>" . $row->NroCupos . '</b><br>';
            }
            echo "--------------------------------------------------------------<br>";
            $sqlhc = "SELECT * FROM HISTCLINICA WHERE NRO_HC='$hc'";
            $consultahc = $ConexionDB->prepare($sqlhc);
            $consultahc->execute();
            $registro = $consultahc->fetchAll(PDO::FETCH_OBJ);
            foreach ($registro as $reg) :
                echo "Historia Clínica : <b> " . $hc . '</b>';
                echo "Nro de Doc : <b> " . $reg->NroDoc . '</b><br>';
                $nrodoc = $reg->NroDoc;
                echo "Paciente : <b> " . $reg->Nombres . '</b><br>';
                $paciente = $reg->Nombres;

                echo "Sexo : <b> " . $reg->Sexo_Hc . '</b>&nbsp;&nbsp;';
                $sexo = $reg->Sexo_Hc;
                echo "Fecha de Nac : <b> " . $reg->FechaNac_HC . '</b><br>';
                $fechanac = $reg->FechaNac_HC;
                echo "Celular : <b> " . $reg->Celular_hc . '</b><br>';
                $celular = $reg->Celular_hc;
                echo '<input type=hidden value=' . $orden . '>';
            endforeach;

            $sql1 = "SELECT * FROM TURNOsXDIA WHERE Id_horario='$horario'";
            $consulta = $ConexionDB->prepare($sql1);
            $consulta->execute();
            $registro2 = $consulta->fetchAll(PDO::FETCH_OBJ);
            foreach ($registro2 as $row) {
                $idhorario = $row->Id_horario;
                //$horario = $row->Id_horario;
            }


            ?>
            <hr>
            <form name=HC method="post" action="../Models/M_citaconfirmada2.php">
                <!--<form name=HC method="post" action="citaconfirmada2.php">-->
                <div class="input-group form-group ">
                    <div class="col-md-2">
                        <a href="../Views/citas2.php?nro=<?php echo $horario ?>&hc=<?php echo $hc ?>&Nro_orden=<?php echo $orden ?>" type="button" class="btn btn-outline-info">Regresar</a>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2">
                        <input type="hidden" name="horario" class="form-control" value="<?php echo $horario ?>">
                        <input type="hidden" name="Nro_orden" class="form-control" value="<?php echo $orden ?>">
                        <input type="hidden" name="txthc" value="<?php echo $hc ?>" class="form-control" placeholder="Nro de HC">
                    </div>
                    <div class="col-md-1">
                    </div>&nbsp;
                    <div class="col-md-2">
                        <input type="hidden" name="celular" value="<?php echo $celular ?>" class="form-control" placeholder="Número de Documento">
                    </div>
                    <div class="col-md-2">
                        <button type=submit name="buscar" class="btn btn-outline-info">Confirmar</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Orden</th>
                        <th scope="col">Historia Clínica</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Condición</th>
                        <th scope="col">Horainicio</th>
                        <th scope="col">Horafinal</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $sql = "SELECT * FROM citashc WHERE id_horario='$horario' order by orden";
                    $consulta = $ConexionDB->prepare($sql);
                    $consulta->execute();
                    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
                    foreach ($registro as $row) : ?>
                        <!--<form name=HC method="post" action="../Controllers/C_citaview.php">-->
                        <th scope="row"><?php echo $row->orden ?></th>
                        <td><?php echo $row->Nro_HC ?></td>
                        <td><?php echo $row->Nombres ?></td>
                        <td><?php echo $row->Sigla_Seguro ?></td>
                        <td><?php echo $row->horainicio ?></td>
                        <td><?php echo $row->horafin ?></td>
                        <td>
                            <!--<input type="hidden" name="horario" class="form-control" value="<?php echo $horario ?>">
                                <input type="hidden" name="cita" class="form-control" value="<?php echo $row->Nro_Cita ?>">
                                <button type=submit name="buscar" class="btn btn-outline-info">Ver 1 </button>-->
                            <a class="btn btn-outline-info" role="button" href="citaview2.php?horario=<?php echo $horario ?>&cita=<?php echo $row->Nro_Cita ?>">Ver Cita</a>
                            <a class="btn btn-outline-success" role="button" href="../Controllers/C_reporte2.php?horario=<?php echo $horario ?>&cita=<?php echo $row->Nro_Cita ?>">Imprimir</a>
                            <a class="btn btn-outline-warning" role="button" href="../Models/M_citaelimina2.php?nro=<?php echo $horario ?>&cita=<?php echo $row->Nro_Cita ?>&nro_orden=<?php echo $orden ?>&hc=<?php echo $hc ?>" onclick="return confirm('Estas seguro?')">Eliminar</a>

                        </td>
                        </tr>
                        </form>
                    <?php
                    endforeach;
                    ?>

                </tbody>
            </table>
            <hr>
            <div class="input-group form-group ">
                <div class="col-md-5">
                </div>
                <div class="col-md-2">
                    <a type="button" class="btn btn-outline-secondary " href="../Controllers/C_citasreport.php?nro=<?php echo $horario ?>&fecha=<?php echo $fecha ?>&prof=<?php echo $prof ?>">Imprimir listado</a>
                </div>
                <div class="col-md-5">
                </div>
            </div>

        </div>
    </div>
</div>
<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>