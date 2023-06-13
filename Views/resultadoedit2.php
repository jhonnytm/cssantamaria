<?php
session_start();
require_once('../Config/Conexion2.php');
include_once('menu/header.php');

$orden = $_GET['Nro_orden'];
$idexamen = $_GET['idexamen'];
$estado = $_GET['estado'];


$sql = "SELECT * FROM  ordendetalleexamen WHERE Nroorden='$orden' and Id_examen='$idexamen'";
$consulta = $ConexionDB->prepare($sql);
$consulta->execute();
$fila = $consulta->fetchAll(PDO::FETCH_OBJ);
foreach ($fila as $row) :
    $nrodetalle = $row->NroDetalle;
endforeach;


?>
<div class="container">
    <div class="card card-5">
        <div class="card-body">
            <div>
                <h4 class="modal-title" id="myModalLabel">Modifica Resultado</h4>
            </div>


            <?php
            /*$sqlexam = "SELECT * FROM ordenlabsubdet2 where nro_detalle='$nrodetalle' and Id_examen='$idexamen'";*/
            $sqlexam="SELECT * FROM EXAMSUBCAT WHERE ID_EXAMEN='$idexamen'";
            $consultaexam = $ConexionDB->query($sqlexam);
            $resultadoexam = $consultaexam->fetchAll(PDO::FETCH_OBJ);
            
            if (empty($resultadoexam)) {

            ?>
                <form action="../Models/M_resultadoedit.php" method="post" name="resultado">

                    <label>Examen de laboratorio :</label><br>
                    <input type=hidden name="nroorden" value="<?php echo $row->Nroorden ?>">
                    <input type=hidden name="idexamen" value="<?php echo $row->Id_Examen;
                                                                $idexam = $row->Id_Examen ?>">
                    <input type=hidden name="estado" value="<?php echo $estado ?>">
                    <input class="custom-select mr-sm-2 form-control" type=text name="examen" size="75%" value="<?php echo $row->Descexamen ?>" readonly><br>
                    <label>Resultado :</label><br>
                    <input class=form-control type=text name="resultado" size="100%" value="<?php echo $row->Resultado_uno ?>">
                    <button type="submit" name="editar" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>
                </form>
            <?php  } else { ?>

                <form action="../Models/M_resultadoedits.php" method="post" name="resultado">

                    <label>Examen de laboratorio :</label><br>
                    <input type=hidden name="nroorden" value="<?php echo $row->Nroorden ?>">
                    <input type=hidden name="idexamen" value="<?php echo $row->Id_Examen;
                                                                $idexam = $row->Id_Examen ?>">
                    <input type=hidden name="estado" value="<?php echo $estado ?>">
                    <input class=form-control type=text name="examen" size="75%" value="<?php echo $row->Descexamen ?>" readonly><br>
                    <input type=hidden name="nrodetalle" value="<?php echo $row->NroDetalle ?>">
                    <label>Resultado :</label><br>
                    <div class="input-group form-group ">
                        <div class="col-md-6">
                            <?php

                            ?>
                            <select class="custom-select mr-sm-2 form-control" name="cboexamsub" id="cboexamsub">
                                <option selected value=0><?php echo $row->Descexamen ?></option>
                                <?php
                                $sqlex = "SELECT * FROM examsubcat where Id_examen='$idexamen'";
                                $consultaex = $ConexionDB->query($sqlex);
                                $resultadoex = $consultaex->fetchAll(PDO::FETCH_OBJ);
                                foreach ($resultadoex as $regi) :
                                    echo '<option value="' . $regi->id_examsubcat . '">' .$regi->Descripcion  . '</option>';
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input class=form-control type=text name="resultado" size="50%">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="agrgarsub" value="Agregar" class="btn btn-outline-warning">Agregar</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Resultado</th>
                                    <th scope="col">Fecha</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqlexam = "SELECT * FROM ordenlabsubdet2 where nro_detalle='$nrodetalle' and Id_examen='$idexamen'";
            //$sqlexam="SELECT * FROM EXAMSUBCAT WHERE ID_EXAMEN='$idexamen'";
            $consultaexam = $ConexionDB->query($sqlexam);
            $resultadoexam = $consultaexam->fetchAll(PDO::FETCH_OBJ);
                                if (empty($resultadoexam)){
                                    //echo "no hay datos";
                                    
                                }else{
                                    foreach ($resultadoexam as $registro) :
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $registro->Descripcion ?></th>
                                                <td><?php echo $registro->Resultado  ?></td>
                                                <td><?php echo $registro->Fecha ?></td>
                                            <tr>
                                            <?php
                                        endforeach;
                                          
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!--                    <table>
                        <tr>
                            <th scope="col">Descripción</th>
                            <th></th>
                        </tr>
                        <?php
                        //foreach ($resultadoexam as $registro) :
                        ?>
                            <td><input class=form-control type=hidden name="nrodetalle" size="10%" value="<?php echo $registro->Nro_detalle ?>"></td>
                            <td><input class=form-control type=hidden name="idexamen" size="10%" value="<?php echo $registro->Id_examen ?>"></td>
                            <td><input class=form-control type=hidden name="idexamsubcat" size="10%" value="<?php echo $registro->Id_examsubcat ?>"></td>
                            <th scope="row"><?php echo $registro->Descripcion ?>:</th>
                            </td>
                            <td><input class=form-control type=text name="resultado" size="50%" value="<?php echo $registro->Resultado ?>"></td>
                            <td><button type="submit" name="editar" class="btn btn-success">Actualiza</button></td>
                            </tr>
                            <button type="submit" name="editar" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Guardar</button><br>
                        <?php
                        //endforeach;
                        ?>
                    </table>
                    <input type=text name="resultado" size="100%" value="<?php echo $registro->Resultado ?>">-->

                    <?php
                    //}
                    ?>

                <?php
            }
                ?>
                </form>
                <a class="btn btn-outline-warning" role="button" href="../Views/ordenlabviews.php?Nro_orden=<?php echo $row->Nroorden ?>&estado=<?php echo $estado ?>">Volver</a>
        </div>
    </div>
</div>