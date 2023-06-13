<?php
require_once('../Config/Conexion2.php');
?>
<div class="modal fade" role="dialog" id="resultadoedit_<?php echo $row->Id_Examen ?>">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Modifica Resultado</h4>
        </div>
        <div class="modal-body">
            <?php
            $sqlexam = "SELECT * FROM ordenlabsubdet where nro_detalle='$row->NroDetalle' and Id_examen='$row->Id_Examen'";
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

                <form action="../Models/M_resultadoedit2.php" method="post" name="resultado">

                    <label>Examen de laboratorio :</label><br>
                    <input type=hidden name="nroorden" value="<?php echo $row->Nroorden ?>">
                    <input type=hidden name="idexamen" value="<?php echo $row->Id_Examen;
                                                                $idexam = $row->Id_Examen ?>">
                    <input type=hidden name="estado" value="<?php echo $estado ?>">
                    <input class=form-control type=text name="examen" size="75%" value="<?php echo $row->Descexamen ?>" readonly><br>
                    <input type=hidden name="nrodetalle" value="<?php echo $row->NroDetalle ?>">
                    <label>Resultado :</label><br>
                    <table>
                        <tr>
                            <td>Tipo :</td>
                            <td>Resultado </td>
                        </tr>
                        <?php
                        foreach ($resultadoexam as $registro) :
                        ?>
                            <td><input class=form-control type=text name="nrodetalle" size="10%" value="<?php echo $registro->Nro_detalle ?>"></td>
                            <td><input class=form-control type=text name="idexamen" size="10%" value="<?php echo $registro->Id_examen ?>"></td>
                            <td><input class=form-control type=text name="idexamsubcat" size="10%" value="<?php echo $registro->Id_examsubcat ?>"></td>
                            </td>
                            <td><input class=form-control type=text name="resultado" size="50%" value="<?php echo $registro->Resultado ?>"></td>
                            <td><button type="submit" name="editar" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Actualiza</button></td>
                            </tr>
                            <!--<button type="submit" name="editar" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>Guardar</button><br>-->
                        <?php
                        endforeach;
                        ?>

                    </table>
                    <!--<input type=text name="resultado" size="100%" value="<?php echo $registro->Resultado ?>">-->
                    <button type="submit" name="editar" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>
                    <?php
                    //}
                    ?>

                <?php
            }
                ?>
                </form>
        </div>
    </div>
</div>
</div>
<?php /*
                                $sqlbusca = "SELECT * FROM examsubcat where id_examsubcat='$registro->Id_examsubcat'";
                                $consultasql = $ConexionDB->query($sqlbusca);
                                $registros->$consultasql->fetchAll(PDO::FETCH_OBJ);
                                foreach ($fila as $reg) :
                                    echo $reg->Descripcion;
                                endforeach;
                                */ ?>