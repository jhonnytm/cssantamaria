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
    $NroHC = $_GET["Nro_HC"];

    $sql = "SELECT * FROM HISTORIACLINICA WHERE NRO_HC=?";
    $sql = $ConexionDB->prepare($sql);
    $sql->execute([$NroHC]);
    $registro = $sql->fetch(PDO::FETCH_OBJ);
    $row1 = $sql->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="input-group form-group">
        <div class="col-md-4">
            <h4>Edición</h4>
        </div>
        <div class="col-md-5"> </div>
        <div class="col-md-3"><strong><?php echo ($_SESSION['nombre']) ?></strong> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <form name=histclinica method="post" action="../Models/M_hcedit.php">
                <div class="input-group forgroup">
                    <div class="col-md-3">
                        <select class="custom-select mr-sm-2 form-control" name="cbotipodoc" id="cbotipodoc">
                            <option selected value=0>Tipo de Documento</option>
                            <?php
                            $sql = $ConexionDB->query("SELECT * FROM TipoDoc");
                            $fila = $sql->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_TipoDoc . '">' . $row->Desc_TipoDoc . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="txtNrodoc" class="form-control" value="<?php echo $registro->NroDoc ?>" required>
                    </div>
                    <div class="col-md-3">
                    <label>Nro de HC :</label>
                    </div>
                    <div class="col-md-3">
                    <input type="text" name="txthc" id="txthc" class="form-control" value="<?php echo $registro->Nro_HC ?>">
                    </div>
                </div>
                <hr>
                <div class="input-group forgroup">
                    <div class="col-md-3">
                        <label>Apellido paterno :</label>
                        <input type="text" name="txtapepat" class="form-control" value="<?php echo $registro->Apepat_HC ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Apellido materno :</label>
                        <input type="text" name="txtapemat" class="form-control" value="<?php echo $registro->Apemat_HC ?>" required>
                    </div>
                    <div class="col-md-6">
                    <label>Nombres :</label>
                        <input type="text" name="txtnombres" id="txtnombres" class="form-control" value="<?php echo $registro->Nombres_HC ?>" required>
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-3">
                        <label>Fecha de Nac. :</label>
                        <input type="date" name="txtfechanac" id="txtfechanac" class="form-control" value="<?php echo $registro->FechaNac_HC ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Género:</label>
                        <select class="custom-select mr-sm-2 form-control" name="cbogenero" id="cbogenero" value="<?php echo $registro->Sexo_HC ?>">

                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Celular:</label>
                        <input type="text" name="txtcelular" class="form-control" minlength="9" maxlength="9" value="<?php echo $registro->Celular_HC ?>" required>
                    </div>
                </div>
                <!--

                    <div class="col-md-3">
                        <label>Estado Civil :</label>
                        <select class="custom-select mr-sm-2 form-control" name="cboestadocivil" id="cboestadocivil" value="<?php echo $registro->EstadoCivil ?>">

                            <option value="Soltero">Soltero(a)</option>
                            <option value="Conviviente">Conviviente(a)</option>
                            <option value="Casado">Casado(a)</option>
                            <option value="4">Divorciado(a)</option>
                            <option value="5">Viudo(a)</option>
                        </select>
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-3">
                        <label>Grado de Instrucción :</label>
                        <select class="custom-select mr-sm-2 form-control" name="cbogradoinst" id="cbogradoinst">
                            <option value="1">Primaria</option>
                            <option value="2">Secundaria</option>
                            <option value="3">Superior</option>
                            <option value="3">Superior incompleta</option>
                            <option value="4">Sin Estudios</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Condición de Seguro :</label>
                        <select class="custom-select mr-sm-2 form-control" name="cbocondseguro" id="cbocondseguro">
                            <?php
                            /*$sql1 = $ConexionDB->query("SELECT Id_Condseguro, Desc_seguro FROM CondSeguro");
                            $fila1 = $sql1->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila1 as $row1) :
                                echo '<option value="' . $row1->Id_Condseguro . '">' . $row1->Desc_seguro . '</option>';
                            endforeach;*/
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Etnia :</label>
                        <select class="custom-select mr-sm-2 form-control" name="cboetnia" id="cboetnia">
                            <?php
                            /*$sql = $ConexionDB->query("SELECT Id_Etnia, Desc_Etnia FROM etnias");
                            $fila = $sql->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_Etnia . '">' . $row->Desc_Etnia . '</option>';
                            endforeach;*/
                            ?>
                        </select>
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-3">
                        <label>Teléfono:</label>
                        <input type="text" name="txttelefono" class="form-control" minlength="7" maxlength="9" value="<?php echo $registro->Telef_HC ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Celular:</label>
                        <input type="text" name="txtcelular" class="form-control" minlength="9" maxlength="9" value="<?php echo $registro->Celular_HC ?>" required>
                    </div>
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-1">
                    </div>
                </div>-->
                <div class="input-group forgroup">
                    <div class="col-md-12">
                        <label>Dirección :</label>
                        <input type="text" name="txtdireccion" class="form-control" value="<?php echo $registro->Direccion_HC ?>" required>
                    </div>
                </div>
                <div class="input-group forgroup">
                    <div class="col-md-3">
                        <label>Departamento :</label>
                        <select class="custom-select mr-sm-2 form-control" name="cbodpto" id="cbodpto">
                            <?php
                            $sql = $ConexionDB->query("SELECT Id_dpto, Desc_dpto FROM dpto WHERE ID_DPTO='15'");
                            $fila = $sql->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->Id_dpto . '">' . $row->Desc_dpto . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Provincia:</label>
                        <select class="custom-select mr-sm-2 form-control" name="prov" id="prov">
                            <?php
                            $sql = $ConexionDB->query("SELECT ID_PROV, Desc_PROV, ID_DPTO FROM PROV WHERE ID_DPTO='15'");
                            $fila = $sql->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->ID_PROV . '">' . $row->Desc_PROV . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Distrito:</label>
                        <select class="custom-select mr-sm-2 form-control" name="dist" id="dist">
                            <?PHP
                            $sql = $ConexionDB->query("SELECT ID_DPTO, ID_PROV, ID_DIST, DESC_DIST  FROM DIST WHERE ID_DPTO='15' AND ID_PROV='01'");
                            $fila = $sql->fetchAll(PDO::FETCH_OBJ);
                            foreach ($fila as $row) :
                                echo '<option value="' . $row->ID_DIST . '">' . $row->DESC_DIST . '</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="input-group forgroup">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-2">
                        <a href="hc.php" class="btn btn-outline-secondary">Regresar</a>
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-2">
                        <input type=submit name="editar" class="btn btn-outline-primary" value="Actualizar Paciente">

                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="footer" id="footer">
    <?php
    include_once('menu/footer.php');

    ?>
</div>