<div class="header">
    <?php
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

    $ordenlab = $_GET['Nro_orden'];
    $estado = $_GET['estado'];

    $sql1 = "SELECT * FROM HISTCLINICA WHERE nRO_hC='$nrohc'";
    $consulta = $ConexionDB->query($sql1);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $nombrespaciente = $row->Nombres;
        $nrodoc = $row->NroDoc;
    endforeach;
    if ((isset($ordenlab))) {

        $sql = "SELECT * FROM ORDENLAB WHERE Nro_orden='$ordenlab'";
        $consulta = $ConexionDB->prepare($sql);
        $consulta->execute();
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $orden = $row->Nro_orden;
            $nroordenlab = $row->NroOrdenLab;
            $nrohc = $row->Nro_HC;
            $fechaemision = $row->FechaEmision;
            $prof = $row->Id_Prof;
            $estrategia = $row->Id_EstrategiaS;
            $seguro = $row->Id_CondSeguro;
            $estado = $row->Estado;
            $fechacita = $row->FechaCita;
        endforeach;

        $sql1 = "SELECT * FROM HISTCLINICA WHERE nRO_hC='$nrohc'";
        $consulta = $ConexionDB->query($sql1);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $nombrespaciente = $row->Nombres;
            $nrodoc = $row->NroDoc;
        endforeach;

        $sql = "SELECT * FROM profesionales WHERE Id_prof='$prof'";
        $consulta = $ConexionDB->query($sql);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $nombresprof = $row->Nombres_Prof;
        endforeach;

        $sql = "SELECT * FROM estrasanitaria WHERE Id_estrategias='$estrategia'";
        $consulta = $ConexionDB->query($sql);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $nombreestrategia = $row->Desc_EstrategiaS;
        endforeach;

        $sql = "SELECT * FROM condseguro WHERE Id_CondSeguro='$seguro'";
        $consulta = $ConexionDB->query($sql);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $nombreseguro = $row->Desc_Seguro;
        endforeach;
    ?>
        <div class="container">
            <h2>Orden de Laboratorio</h2>
            <div class="card card-12">
                <div class="card-body">
                    <?php if ($estado === "PENDIENTE") { ?>
                        <form name=detallelab method="POST" action="../Models/M_ordenlabedit.php">
                            <div class="input-group forgroup">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="colspan 2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Número de Orden de Laboratorio :</td>
                                            <td>
                                                <input type="hidden" name="ordenlab" class=form-control value="<?php echo $ordenlab ?>">
                                                <input type="hidden" name="nroordenlab" class=form-control value="<?php echo $nroordenlab ?>">
                                                <b><?php echo $nroordenlab ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Profesional que solicita la orden :</td>
                                            <td>
                                                <input type="hidden" name="prof" class=form-control value="<?php echo $prof ?>">
                                                <b><?php echo $nombresprof ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Condición de Ingreso :</td>
                                            <td>
                                                <input type="hidden" name="seguro" class=form-control value="<?php echo $seguro ?>">
                                                <b><?php echo $nombreseguro ?></b>
                                            </td>
                                            <td>Estrategia :</td>
                                            <td>
                                                <input type="hidden" name="estrategia" class=form-control value="<?php echo $estrategia ?>">
                                                <b><?php echo $nombreestrategia ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Paciente :</td>
                                            <td>
                                                <input type="hidden" name="nrodoc" class=form-control value="<?php echo $nrohc ?>">
                                                <b><?php echo $nombrespaciente ?></b>
                                            </td>
                                            <td>HC : <b><?php echo $nrohc ?></b></td>
                                            <td>N° Doc :<b><?php echo $nrodoc ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Fecha de Solicitud de la orden :</td>
                                            <td>
                                                <input type="hidden" name="fechaemitida" class=form-control value="<?php echo $fechaemision ?>">
                                                <b><?php echo $fechaemision ?></b>
                                            </td>
                                            <td>Estado de la Orden :</td>
                                            <td>
                                                <input type="hidden" name="estado" class=form-control value="<?php echo $estado ?>">
                                                <b><?php echo $estado ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fecha Citada :</td>
                                            <td>
                                                <input type="hidden" name="fechaemitida" class=form-control value="<?php echo $fechaemision ?>">
                                                <b><?php echo $fechacita ?></b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" name="agregarexamen" value="Agregar" class="btn btn-outline-success my-2 my-sm-0">Agregar</button>
                                </div>

                            </div>
                        </form>

                    <?php
                    } else {
                    ?>
                        <form name=detallelab method="POST" action="">
                            <div class="input-group forgroup">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="colspan 2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Número de Orden de Laboratorio :</td>
                                            <th scope="row">
                                                <input type="hidden" name="ordenlab" class=form-control value="<?php echo $ordenlab ?>">
                                                <input type="hidden" name="nroordenlab" class=form-control value="<?php echo $nroordenlab ?>">
                                                <strong><?php echo $nroordenlab ?></strong>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Profesional que solicita la orden :</td>
                                            <th scope="row">
                                                <input type="hidden" name="prof" class=form-control value="<?php echo $prof ?>">
                                                <strong><?php echo $nombresprof ?></strong>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Condición de Ingreso :</td>
                                            <th scope="row">
                                                <input type="hidden" name="seguro" class=form-control value="<?php echo $seguro ?>">
                                                <strong><?php echo $nombreseguro ?></strong>
                                            </th>
                                            <td>Estrategia :</td>
                                            <th scope="row">
                                                <input type="hidden" name="estrategia" class=form-control value="<?php echo $estrategia ?>">
                                                <strong><?php echo $nombreestrategia ?></strong>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Paciente :</td>
                                            <th scope="row">
                                                <input type="hidden" name="nrodoc" class=form-control value="<?php echo $nrohc ?>">
                                                <strong><?php echo $nombrespaciente ?></strong>
                                            </th>
                                            <td>HC : <?php echo $nrohc ?></td>
                                            <td>N° Doc :<?php echo $nrodoc ?></td>
                                        </tr>
                                        <tr>
                                            <td>Fecha de Solicitud de la orden :</td>
                                            <th scope="row">
                                                <input type="hidden" name="fechaemitida" class=form-control value="<?php echo $fechaemision ?>">
                                                <strong><?php echo $fechaemision ?></strong>
                                            </th>
                                            <td>Estado de la Orden :</td>
                                            <th scope="row">
                                                <input type="hidden" name="estado" class=form-control value="<?php echo $estado ?>">
                                                <strong><?php echo $estado ?></strong>
                                            </th>
                                        </tr>
                                        <tr>

                                        </tr>

                                        <tr>
                                            <td>Fecha Citada :</td>
                                            <th scope="row">
                                                <input type="hidden" name="fechaemitida" class=form-control value="<?php echo $fechaemision ?>">
                                                <strong><?php echo $fechacita ?></strong>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    <?php
                    } ?>

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
                                /*$sql = "SELECT 
                            ordenlabdetalle.Nro_orden AS Nroorden, ordenlabdetalle.NroordenLab AS Nroordenlab, 
                            examenes.Desc_examen AS Descexamen, ordenlabdetalle.muestra_uno AS Muestra_uno, 
                            ordenlabdetalle.Resultado_uno AS Resultado_uno, examenes.Unidad_med AS Unidmedida,
                            ordenlabdetalle.muestra_dos AS Muestra_dos, 
                            ordenlabdetalle.Resultado_dos AS Resultado_dos,
                            ordenlabdetalle.muestra_tres AS Muestra_tres, 
                            ordenlabdetalle.Resultado_tres AS Resultado_tres
                            FROM ordenlabdetalle
                            INNER JOIN examenes
                            ON  ordenlabdetalle.Id_Examen=examenes.Id_Examen WHERE Nroorden='$ordenlab'";*/
                                $sql1 = "SELECT  COUNT(Nro_orden) FROM ORDENLABDETALLE WHERE NRO_ORDEN='$ordenlab'";
                                $consulta = $ConexionDB->query($sql1);
                                $nro = $consulta->fetchColumn();

                                $sql = "SELECT * FROM  ordendetalleexamen WHERE Nroorden='$ordenlab'";
                                $consulta = $ConexionDB->prepare($sql);
                                $consulta->execute();
                                $fila = $consulta->fetchAll(PDO::FETCH_OBJ);
                                foreach ($fila as $row) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $nro ?></th>
                                        <td><?php echo $row->Nroordenlab ?></td>
                                        <td><?php echo $row->Muestra_uno ?></td>
                                        <td><?php echo $row->Descexamen ?></td>
                                        <td><?php echo $row->Resultado_uno ?></td>
                                        <td><?php echo $row->Unidmedida ?></td>
                                        <td><?php
                                            if ($estado === "PENDIENTE") { ?>
                                                <a class="btn btn-outline-warning" role="button" href="resultadoedit2.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>">Resultado</a>
                                                <!--<a data-toggle="modal" class="btn btn-outline-warning" role="button" href="resultadoedit.php?<?php echo $row->Id_Examen ?>">Agrega Resultado</a>-->
                                                <a class="btn btn-outline-info" role="button" href="../Models/M_ordenlabelimina.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>" onclick="return confirm('Estas seguro?')">Quitar</a>
                                            <?php }
                                            //include('resultadoedit.php');
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
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
                            <a class="btn btn-outline-warning" role="button" href="citas2.php?hc=<?php echo $nrohc ?>">Emitir Cita</a>
                        </div>
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-outline-success" role="button" href="../Models/M_ordenlabfinaliza.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>" onclick="return confirm('Una vez hecho esto no podrá editar o agregar resultados. Estás seguro?')">Finalizar Orden</a>
                        </div>
                        <!--<div class="col-md-4">
                            <a class="btn btn-outline-success" role="button" href="../Controllers/C_resultado2.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>">Ver en pantalla</a>
                        </div>-->
                        <div class="col-md-2">
                            <a class="btn btn-outline-primary" role="button" href="../Controllers/C_resultado.php?Nro_orden=<?php echo $row->Nroorden ?>&idexamen=<?php echo $row->Id_Examen ?>&estado=<?php echo $estado ?>">Imprimir Resultado</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo "no existes";
        echo $ordenlab;
    }
    ?>
</div>
<div class="footer" id="footer">
    <?php
    include_once('menu/footer.php');
    ?>
</div>