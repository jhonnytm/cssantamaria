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
            $hc = $_POST["hc"];
            //$dni = $_POST["txtdni"];
            $horario = $_POST["horario"];


            $sql = "SELECT * FROM TURNOXDIA WHERE id_horario='$horario'";

            $consulta = $ConexionDB->query($sql);
            $consulta->execute();
            $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
            foreach ($registro as $row) {
                echo "Cartera de Servicios :<b>" . $row->desc_cartera . '</b><br>';
                $cartera = $row->desc_cartera;
                echo "Consultorio :<b>" . $row->desc_consultorio . '</b><br>';
                $consultorio = $row->desc_consultorio;
                echo "Profesional :<b>" . $row->Nombres_Prof . '</b><br>';
                $prof = $row->Nombres_Prof;
                echo "Fecha :<b>" . $row->Fecha . '</b><br>';
                $fecha = $row->Fecha;
                echo "Turno :<b>" . $row->desc_turno . '</b><br>';
                echo "Cupos disponibles :<b>" . $row->NroCupos . '</b><br>';
            }
            $longitud = 8;
            $NroHC = substr(str_repeat(0, $longitud) . $hc, -$longitud);

            $sql3 = "SELECT * FROM HISTCLINICA WHERE Nro_Hc='$NroHC'";
            $consulta3 = $ConexionDB->query($sql3);
            $registro3 = $consulta3->fetchAll(PDO::FETCH_OBJ);
            foreach ($registro3 as $row3) :
                $nrodoc = $row3->NroDoc;
                $nombres = $row3->Nombres;
                $sexo = $row3->Sexo_Hc;
                $celular = $row3->Celular_hc;
                $fechanac = $row3->FechaNac_HC;
            endforeach;
            $sql1 = "SELECT * FROM TURNOsXDIA WHERE Id_horario='$horario'";
            $consulta1 = $ConexionDB->query($sql1);
            $consulta1->execute();
            $registro1 = $consulta1->fetchAll(PDO::FETCH_OBJ);
            foreach ($registro1 as $row1) {
                $idhorario = $row1->Id_horario;
            }
            //echo $horario;
            ?>
            <hr>
            <form name=HC method="post" action="../Models/M_citaconfirmada.php">
                <div class="input-group form-group ">
                    <div class="col-md-2">
                        <a href="citapacientebusca.php?nro='. $horario type=" button" class="btn btn-outline-info">Regresar</a>
                    </div>
                    <div class="col-md-5">
                        <?php
                        if (empty($nombres)) {
                            echo "<font color=red>Historia Clínica no pertenece a ningún paciente registrado</font><br>";
                            echo '<a href=citapacientebusca.php?nro=' . $horario . '>Volver</a>';
                        } else {
                            echo "<b>" . $nombres . "</b>";
                        }
                        ?>
                        <input type="hidden" name="txtdni" value="<?php echo $nrodoc ?>">
                        <input type="hidden" name="horario" value="<?php echo $horario ?>">
                        <input type="hidden" name="hc" value="<?php echo $NroHC ?>">
                    </div>
                    <div class="col-md-3">
                        <select class="custom-select mr-sm-2 form-control" name="cboCondSeguro" id="cboCondSeguro">
                            <option selected value=0>Seguro de Salud</option>
                            <?php
                            $sql = "SELECT Id_Condseguro, Desc_seguro FROM CondSeguro";
                            $seguro = $ConexionDB->query($sql);
                            $fila = $seguro->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_Condseguro . '">' . $row->Desc_seguro . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type=submit name="buscar" class="btn btn-outline-info">Agregar</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Orden</th>
                            <th scope="col">Historia Clínica</th>
                            <th scope="col">Paciente</th>
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
                            <td><?php echo $row->horainicio ?></td>
                            <td><?php echo $row->horafin ?></td>
                            <td>
                                <!--<input type="hidden" name="horario" class="form-control" value="<?php echo $horario ?>">
                                <input type="hidden" name="cita" class="form-control" value="<?php echo $row->Nro_Cita ?>">
                                <button type=submit name="buscar" class="btn btn-outline-info">Ver 1 </button>-->
                                <a class="btn btn-outline-info" role="button" href="Citaview.php?horario=<?php echo $horario ?>&cita=<?php echo $row->Nro_Cita ?>">Ver Cita</a>
                                <a class="btn btn-outline-success" role="button" href="../Controllers/C_reporte1.php?horario=<?php echo $horario ?>&cita=<?php echo $row->Nro_Cita ?>">Imprimir</a>
                                <a class="btn btn-outline-warning" role="button" href="../Models/M_citaelimina.php?nro=<?php echo $horario ?>&cita=<?php echo $row->Nro_Cita ?>" onclick="return confirm('Estas seguro?')">Eliminar</a>

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
</div>
<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>