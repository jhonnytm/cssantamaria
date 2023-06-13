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
            $horario = $_GET['nro'];
            //$cita;

            $sql = "SELECT * FROM TURNOXDIA WHERE id_horario='$horario'";

            $consulta = $ConexionDB->prepare($sql);
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
            $sql1 = "SELECT * FROM TURNOsXDIA WHERE Id_horario='$horario'";
            $consulta = $ConexionDB->prepare($sql1);
            $consulta->execute();
            $registro2 = $consulta->fetchAll(PDO::FETCH_OBJ);
            foreach ($registro2 as $row) {
                $idhorario = $row->Id_horario;
                //$horario = $row->Id_horario;
            }
            //echo $horario;
            ?>
            <hr>
            <form name=HC method="post" action="../Models/M_citaconfirmada.php">

                <div class="input-group form-group ">
                    <div class="col-md-2">
                        <a href="../Views/citas.php" type="button" class="btn btn-outline-info">Regresar</a>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <!--<input type="text" name="txtdni" class="form-control" placeholder="Número de Documento">-->
                        <input type="hidden" class="form-control" value="<?php echo $horario ?>" name="horario">
                        <input type="text" name="txthc" class="form-control" placeholder="Nro de HC">
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