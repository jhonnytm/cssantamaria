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
    //$nrohc = $_GET['nrohc'];
    //$nrodoc=$_GET['nrodoc'];


    /*$sqlbusca = "SELECT * FROM HISTCLINICA WHERE NRO_HC =$nrohc";
    //echo $sqlbusca;
    $consulta = $ConexionDB->query($sqlbusca);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $nombrespaciente = $row->Nombres;
        $sexo = $row->Sexo_Hc;
        $nrodoc = $row->NroDoc;
        $hc = $row->Nro_HC;
        $celular = $row->Celular_hc;
    endforeach;*/
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
            <form name=detallelab method="POST" action="ordenlabnew3alterB.php">
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
                <div class="input-group forgroup">
                    <div class="col-md-3">
                        <label>HC u otro documento :</label>
                    </div>
                    <div class="col-md-3">
                        <input type=Text name="nrohc" class="form-control" placeholder="Historia Clínica">
                    </div>
                    <div class="col-md-1">
                        <strong>O</strong>
                    </div>
                    <div class="col-md-3">
                        <input type=Text name="nrodoc" class="form-control" placeholder="Nro de Documento">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" name="agregarexamen" value="Agregar" class="btn btn-outline-success my-2 my-sm-0">Buscar paciente</button>
                    </div>
                </div>
            </form>
            <table width=100%>
                <tr>
                    <td>Paciente :</td>
                    <td>
                        <input type="hidden" name="nrohc" class=form-control value="<?php //echo $nrohc 
                                                                                    ?>">
                        <b><?php //echo $nombrespaciente 
                            ?></b>
                    </td>
                    <td>HC : </td>
                    <td><b><?php //echo $nrohc 
                            ?></b>
                        <input type="hidden" name="nrohc" class=form-control value="<?php //echo $nrohc 
                                                                                    ?>">
                    </td>
                    <td>N° Doc :</td>
                    <td><b><?php //echo $nrodoc 
                            ?></b>
                        <input type="hidden" name="nrodoc" class=form-control value="<?php //echo $nrodoc 
                                                                                        ?>">
                    </td>
                </tr>
                <tr>
                    <td>Celular:</td>
                    <td><b><?php //echo $celular 
                            ?></b></td>
                    <td>Genero :</td>
                    <td><b><?php //echo $sexo 
                            ?></b></td>
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
                <div class="col-md-3">
                    <b>Ingrese :</b>
                </div>
                <div class="col-md-6">
                    <select class="custom-select mr-sm-2 form-control" name="cboexamen" id="cboexamen">
                        <option selected>Examen de Laboratorio :</option>
                        <?php
                        $sql = "SELECT * FROM EXAMENES order by Desc_examen asc";
                        $consulta = $ConexionDB->prepare($sql);
                        $consulta->execute();
                        $fila = $consulta->fetchAll(PDO::FETCH_OBJ);
                        foreach ($fila as $row) :
                            echo '<option value="' . $row->Id_Examen . '">' . $row->Desc_examen . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="agregarexamen" value="Agregar" class="btn btn-outline-success my-2 my-sm-0">Agregar</button>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Fecha Citada</th>
                            <th scope="col">Fecha entrega </th>
                            <th scope="col">Examen Lab</th>
                            <th scope="col">Resultado</th>
                            <th scope="col">Uni Medida</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        /*$sql1 = "SELECT  COUNT(Nro_orden) FROM ORDENLABDETALLE WHERE NRO_ORDEN='$ordenlab'";
                        $consulta = $ConexionDB->query($sql1);
                        $nro = $consulta->fetchColumn();



                        $sql = "SELECT * FROM  ordendetalleexamen WHERE Nroorden='$ordenlab'";
                        $consulta = $ConexionDB->prepare($sql);
                        $consulta->execute();
                        $fila = $consulta->fetchAll(PDO::FETCH_OBJ);
                        foreach ($fila as $row) {*/
                        ?>
                        <tr>
                            <th scope="row"><?php //echo $nro 
                                            ?></th>
                            <td><?php //echo $row->Nroordenlab 
                                ?></td>
                            <td><?php //echo $row->Muestra_uno 
                                ?></td>
                            <td><?php //echo $row->Descexamen 
                                ?></td>
                            <td><?php // echo $row->Resultado_uno 
                                ?></td>
                            <td><?php //echo $row->Unidmedida 
                                ?></td>
                            <td><?php
                                //if ($estado === "PENDIENTE") { 
                                ?>
                                <!--<a class="btn btn-outline-warning" role="button" href="resultadoedit.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>">Resultado</a>
                                <a data-toggle="modal" class="btn btn-outline-warning" role="button" href="#resultadoedit_<?php echo $row->Id_Examen ?>">Agrega Resultado</a>
                                <a class="btn btn-outline-info" role="button" href="../Models/M_ordenlabelimina.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>" onclick="return confirm('Estas seguro?')">Quitar</a>-->
                                <?php //}
                                //include('resultadoedit.php');
                                ?>
                            </td>
                        </tr>
                        <?php
                        //}


                        ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="input-group forgroup">
                <div class="col-md-3">
                    <a class="btn btn-outline-info" role="button" href="ordenlab.php">Ver Listado</a>
                </div>
                <div class="col-md-3">
                    <a class="btn btn-outline-warning" role="button" href="../Models/M_citas2pre.php?hc=<?php echo $nrohc ?>&Nro_orden=<?php echo $row->Nroorden ?>&estado=<?php echo $estado ?>">Emitir Cita</a>
                </div>
                <div class="col-md-1">

                </div>
                <div class="col-md-3">
                    <a class="btn btn-outline-success" role="button" href="../Models/M_ordenlabfinaliza.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>" onclick="return confirm('Una vez hecho esto no podrá editar o agregar resultados. Estás seguro?')">Finalizar Orden</a>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-outline-primary" role="button" href="../Controllers/C_resultado.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>">Imprimir Resultado</a>
                </div>
            </div>
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