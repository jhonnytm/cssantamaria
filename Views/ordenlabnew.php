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
        <div class="col-md-6">
            <b>Generar Orden de Laboratorio</b>
        </div>
        <div class="col-md-3"> </div>
        <div class="col-md-3"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <form name="ordenlab" method="POST" action="../Models/M_ordenlabnew.php">

                <div class="input-group forgroup">
                    <div class="col-md-2">
                        <label> <strong>Fecha actual :</strong> </label>
                    </div>
                    <div class="col-md-3">
                        <input type=text class="form-control" name="fechaactual" readonly value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-2">
                        <label> <strong>Número Temporal :</strong> </label>
                    </div>
                    <div class="col-md-3">
                        <input type=text class="form-control" name="nroordenlab" readonly>
                    </div>
                </div>
                <hr>
                <strong>Datos del paciente :</strong>
                <div class="input-group forgroup">
                    <div class="col-md-2">
                        <label>HC u Otro Doc:</label>
                    </div>
                    <div class="col-md-3">
                        <input type=Text name="nrohc" class="form-control" placeholder="Historia Clínica">
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-2">
                        <label>Celular :</label>
                    </div>
                    <div class="col-md-3">
                        <input type=Text name="nrodoc" class="form-control" placeholder="Nro de celular">
                    </div>
                </div>
                <hr>
                <b>Condición de la Orden :</b>
                <div class="input-group forgroup">
                    <div class="col-md-2">
                        <label>Condición ingreso :</label>
                    </div>
                    <div class="col-md-4">

                        <select class="custom-select mr-sm-2 form-control" name="cbocondseguro" id="cboCondSeguro">
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
                    <div class="col-md-3">
                        <label>Número de Recibo O FUA:</label>
                    </div>
                    <div class="col-md-3">
                        <input type=Text name="nrorecibofua" class=form-control>
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-2">
                        <label>Profesional tratante : </label>
                    </div>
                    <div class="col-md-4">

                        <select class="custom-select mr-sm-2 form-control" name="cboprof" id="cboprof">
                            <option selected value=0>Profesional de Salud</option>
                            <?php
                            $sql = "SELECT Id_Prof, Nombres_Prof FROM Profesionales where Id_EESS='5625' and laborasist='SI' ORDER BY NOMBRES_PROF";
                            $seguro = $ConexionDB->query($sql);
                            $fila = $seguro->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_Prof . '">' . $row->Nombres_Prof . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Fecha de Emisión de la Orden:</label>
                    </div>
                    <div class="col-md-3">
                        <input type=date class="form-control" name="fechaemision" value="<?php echo date('Y-m-d') ?>">
                    </div>

                </div>
                <div class="input-group forgroup">
                    <div class="col-md-2">
                        <label>Estrategia Sanitaria</label>
                    </div>
                    <div class="col-md-4">

                        <select class="custom-select mr-sm-2 form-control" name="cboestrategia" id="cboestrategia">
                            <option selected value=0>Estrategia Sanitaria</option>
                            <?php
                            $sql = "SELECT Id_EstrategiaS, Desc_EstrategiaS FROM estrasanitaria";
                            $seguro = $ConexionDB->query($sql);
                            $fila = $seguro->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_EstrategiaS . '">' . $row->Desc_EstrategiaS . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Estado</label>
                    </div>
                    <div class="col-md-3">
                        <input type=Text name="estado" class=form-control value="PENDIENTE" readonly>
                    </div>
                </div>
                <strong><!--Ingrese al menos un examen de laboratorio solicitado :--></strong>
                <br>
                <div class="input-group forgroup">
                    <div class="col-md-4">
                        <!--<select class="custom-select mr-sm-2 form-control" name="cboexamen" id="cboexamen">
                            <option selected>Examen de Laboratorio :</option>
                            <?php
                            /*$sql = "SELECT * FROM EXAMENES";
                            $consulta = $ConexionDB->prepare($sql);
                            $consulta->execute();
                            $fila = $consulta->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_Examen . '">' . $row->Desc_examen . '</option>';
                            endforeach;*/
                            ?>
                        </select>-->
                    </div>
                    <div class="col-md-1">
                        <!--<label>Resultado:</label>-->
                    </div>
                    <div class="col-md-2">
                        <!--<input type=Text name="resultado_uno" class=form-control>-->
                    </div>
                    <div class="col-md-2">
                        <!--<label>Fecha de tomada:</label>-->
                    </div>
                    <div class="col-md-3">
                        <!--<input type=date name="fechamuestra_uno" class="form-control">-->
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
                <hr>
                <div class="input-group forgroup">
                    <div class="col-md-2">
                        <a class="btn btn-info" role="button" href="../Views/ordenlab.php">Regresar</a>
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="agregarexamen" value="Agregar" class="btn btn-outline-success my-2 my-sm-0">Continuar</button>
                        <!--<button type=submit value="Siguiente" class="btn btn-info">Siguiente </button>-->
                        <!--<a class="btn btn-info" role="button" href="ordenlabreg2.php?nro=nrodoc&tipodoc=cbotipodoc&seguro=cbocondseguro&prof=cboprof&estrategia=cboestrategia$fecha=fechaorden">Siguiente</a>-->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class=footer id footer>
        <?php include_once('menu/footer.php'); ?>
    </div>