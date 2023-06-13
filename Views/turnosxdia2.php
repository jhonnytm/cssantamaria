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

    $mifecha = $_POST['fecha'];

    if (empty($_POST['cbocartera'])) {
        header('Location: turnosxdia1.php');
        die();
    }
    $mifechacrea = date('Y-m-d H:i:s');

    $cartera = $_POST['cbocartera'];


    /*$fecha = date('Y-m-d');
    $sql = "SELECT * FROM TURNOxDIA WHERE FECHA='$fecha%'";

    if (isset($_POST['buscar'])) {
        $mifecha = $_POST['fechita'];
        $sql = "SELECT * FROM TURNOXDIA WHERE FECHA  ='$mifecha'";
    } else {
    }
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute();
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);*/

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

            <form id="ProgTurno" name="ProgTurno" method="post" action="turnosxdia3.php">
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
                    </div>
                    <div class="col-md-8">
                        <label>Seleccione Consultorio : </label>
                        <select class="custom-select mr-sm-2 form-control" name="cboconsultorio" id="cboconsultorio">
                            <option selected value=0>Consultorio</option>
                            <?php
                            $sql = " SELECT * FROM consultorios where id_cartera='$cartera'";
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

                    <div class="col-md-2">
                        <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button type="submit" name="guardar" value="Agregar" class="btn btn-outline-primary">Agregar</button>
                    </div>
                </div>
            </form>

            <div class="footer" id="footer">
                <?php include_once('menu/footer.php'); ?>
            </div>