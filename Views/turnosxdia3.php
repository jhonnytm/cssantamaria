<div class="header">
    <?php
    session_start();
    date_default_timezone_set("America/Lima"); //Zona horaria de Peru  
    include_once('menu/header.php');

    if (!isset($_SESSION['nombre'])) {
        header:
        ('Location: ../index.php');
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
    $sql = "SELECT * FROM TURNOxDIA WHERE FECHA='$fecha%'";

    if (isset($_POST['buscar'])) {
        $mifecha = $_POST['fechita'];
        $sql = "SELECT * FROM TURNOXDIA WHERE FECHA  ='$mifecha'";
    } else {
    }
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute();
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);

    ?>
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Asignación de turnos</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">

            <form id="ProgTurno" name="ProgTurno" method="post" action="../Models/M_turnosxdia.php">
                <div class="input-group forgroup">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-4">
                        <label><strong> Seleccione Fecha :</strong> </label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-8">

                        <label>Seleccione Cartera de Servicio : </label>
                        <select class="custom-select mr-sm-2 form-control" name="cbocartera" id="cbocartera">
                            <option selected value="0">Cartera de Servicio</option>
                            <?php
                            $sql = " SELECT * FROM CARTERASERV";
                            $consulta = $ConexionDB->query($sql);
                            $fila = $consulta->fetchAll(PDO::FETCH_OBJ); ?>
                            <?php
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_Cartera . '">' . $row->Desc_Cartera . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-8">
                        <label>Seleccione Consultorio : </label>
                        <select class="custom-select mr-sm-2 form-control" name="cboconsultorio" id="cboconsultorio">
                            <option selected value=0>Consultorio</option>
                            <?php
                            $sql = " SELECT * FROM consultorios";
                            $consulta = $ConexionDB->query($sql);
                            $fila = $consulta->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_Consultorio . '">' . $row->Desc_consultorio . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                        <label>Seleccione Profesional : </label>
                        <select class="custom-select mr-sm-2 form-control" name="cboprof" id="cboprof">
                            <option selected value=0>Profesional de la Salud</option>
                            <?php
                            $sql = " SELECT * FROM Profesionales where Id_EESS='5625' AND laborasist='SI'";
                            $consulta = $ConexionDB->query($sql);
                            $fila = $consulta->fetchAll(PDO::FETCH_OBJ); ?>
                            <?php
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_Prof . '">' . $row->Nombres_Prof . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <label>Seleccione turno : </label>
                        <select class="custom-select mr-sm-2 form-control" name="cboturno" id="cboturno">
                            <option selected value=0>Turno ...</option>
                            <option value="1">Mañana</option>
                            <option value="2">Tarde</option>
                            <option value="3">Guardia</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Cupos : </label>
                        <input type="text" name="txtcupos" class="form-control" placeholder="Cupos">
                    </div>
                    <div class="col-md-2">
                        <label>Adicionales :</label>
                        <input type="text" name="txtadicionales" class="form-control" placeholder="adicionales">
                    </div>
                    <div class="col-md-2">
                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button type="submit" name="guardar" value="Agregar" class="btn btn-outline-primary">Agregar</button>
                    </div>
                </div>
            </form>
            <hr>
            <form id="Turno" name="Turno" method="post" action="turnosxdia.php">
                <div class="input-group forgroup">
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                        <input type="date" name="fechita" id=fecha class="form-control" value="<?php echo date('Y-m-d') ?>">
                        <!--<input type="date" name="fechita2" id=fecha class="form-control" value="<?php echo date('Y-m-d') ?>">-->
                    </div>
                    <div class="col-md-2">
                        <button type=submit name="buscar" id=buscar class="btn btn-outline-success">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cartera</th>
                            <th scope="col">Consultorio</th>
                            <th scope="col">Profesional</th>
                            <th scope="col">Turno</th>
                            <th scope="col">Cupos</th>
                            <th scope="col">Adicionales</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //if (!empty($datos)) :
                        $sqlfiltro = " SELECT * FROM turnosxdia ";
                        $sql1 = "SELECT * FROM turnosxdia WHERE fecha BETWEEN '2023-03-02' AND '2023-03-31'";
                        $consulta2 = $ConexionDB->query($sql);
                        //$fila = $consulta->fetchAll(PDO::FETCH_OBJ);
                        foreach ($registro as $row) : ?>
                            <tr>
                                <th scope="row"><?php echo $row->Fecha ?></th>
                                <td><?php echo $row->desc_cartera ?></td>
                                <td><?php echo $row->desc_consultorio ?></td>
                                <td><?php echo $row->Nombres_Prof ?></td>
                                <td><?php echo $row->desc_turno ?></td>
                                <td><?php echo $row->NroCupos ?></td>
                                <td><?php echo $row->adicionales ?></td>
                                <td>
                                    <a class="btn btn-danger" role="button" href="../Models/M_turnoelimina.php?Nro=<?php echo $row->Id_horario ?>" onclick="return confirm('Estas seguro?')">Eliminar</a>
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
<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>