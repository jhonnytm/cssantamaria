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
    <?php
    $nrohc = $_GET['nrohc'];
    //$nrodoc=$_GET['nrodoc'];


    $sqlbusca = "SELECT * FROM HISTCLINICA WHERE NRO_HC =$nrohc";
    //echo $sqlbusca;
    $consulta = $ConexionDB->query($sqlbusca);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $nombrespaciente = $row->Nombres;
        $sexo = $row->Sexo_Hc;
        $nrodoc = $row->NroDoc;
        $hc = $row->Nro_HC;
        $nac = $row->FechaNac_HC;
        $celular = $row->Celular_hc;
    endforeach;

    $anioact = date('Y');
    $mesact = date('m');

    $fecnac = strtotime($nac);
    $anionac = date('Y', $fecnac);
    $mesnac = date('m', $fecnac);
    $mes = $mesact - $mesnac;
    if ($mes < 0) {
        $mess = 12 + $mes;
    } else {
        $mess = $mes;
    }
    if (($mesact > $mesnac) or ($mesact = $mesnac))  {

        $edad = $anioact - $anionac;
    } else {
        $edad = ($anioact - $anionac) - 1;
    }

    //$edad = $anio - $anio2;
    ?>
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Generar Orden de Laboratorio</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-12">
        <div class="card-body">
            <form name=detallelab method="POST" action="../Models/M_ordenlabnew3.php">
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
                <br>
                <table width=100%>
                    <tr>
                        <td>Paciente :</td>
                        <td>
                            <input type="hidden" name="nrohc" class=form-control value="<?php echo $nrohc ?>">
                            <b><?php echo $nombrespaciente ?></b>
                        </td>
                        <td>HC : </td>
                        <td><b><?php echo $nrohc ?></b>
                            <input type="hidden" name="nrohc" class=form-control value="<?php echo $nrohc ?>">
                        </td>
                        <td>N° Doc :</td>
                        <td><b><?php echo $nrodoc ?></b>
                            <input type="hidden" name="nrodoc" class=form-control value="<?php echo $nrodoc ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Edad :</td>
                        <td><b><?php echo $edad . ' Años ' . $mess . ' meses ' ?></b></td>

                        <td>Fecha Nac :</td>
                        <td><b><?php echo $nac ?></b></td>

                        <td>Genero :</td>
                        <td><b><?php echo $sexo ?></b></td>
                        <td></td>
                        <td><b>NO es el paciente? &nbsp;<a href="ordenlabnew2.php">Atrás</a></b></td>
                    </tr>
                </table>
                <br>
                <b>Condición de la Orden :</b>
                <div class="input-group forgroup">
                    <div class="col-md-2">
                        <label>Modalidad ingreso:</label>
                    </div>
                    <div class="col-md-4">
                        <select class="custom-select mr-sm-2 form-control" name="cbocondseguro" id="cbocondseguro">
                            <option selected value=0>Modalidad de ingreso</option>
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
</div>
<div class=footer id footer>
    <?php include_once('menu/footer.php'); ?>
</div>
<!--



//------*******************************-
   /* $fechaemision = $_POST['fechaemision'];
    $prof = $_POST['cboprof'];
    $estrategia = $_POST['cboestrategia'];
    $seguro = $_POST['cbocondseguro'];
    $nrorecibofua = $_POST['nrorecibofua'];
    $estado = "PENDIENTE";
    $impreso = "NO";

    $sql = "INSERT INTO ORDENLAB (Nroordenlab, Nro_HC, FechaEmision, Id_Prof, Id_EstrategiaS, Id_CondSeguro, nrorecibofua, Fecharegistro, estado, impreso) 
    VALUE (?,?,?,?,?,?,?,?,?,?)";
    $sql = $ConexionDB->prepare($sql);
    $resultado = $sql->execute([$nroordenlab, $nrohc,  $fechaemision, $prof, $estrategia, $seguro, $nrorecibofua, $mifecha, $estado, $impreso]);
    $orden = $ConexionDB->lastInsertId();

    if ($resultado) {
        header('Location: ../Views/ordenlabview.php?Nro_orden=' . $orden . '&estado=' . $estado);
    } else {
        header('Location: ../Views/ordenlabnew.php');
    }*/
}
-->