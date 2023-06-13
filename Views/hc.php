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
    $sql = "SELECT * FROM histclinica ORDER BY Nro_HC DESC LIMIT 15";

    if (isset($_POST['buscar'])) {
        $apepat = $_POST['txtapepat'];
        $hc = $_POST['txthc'];
        $doc = $_POST['txtdni'];

        $longitud = 8;
        $nrohc = substr(str_repeat(0, $longitud) . $hc, -$longitud);

        if (($apepat == "") && ($doc == "") && ($hc == "")) {
            $condicion = "";
        } elseif (!empty($apepat)) {
            $condicion = "WHERE nombres like '" . $apepat . "%'";
        } elseif (!empty($doc)) {
            $condicion = "WHERE NroDoc ='" . $doc . "'";
        } else {
            $condicion = "WHERE Nro_HC ='" . $nrohc . "'";
        }
        $sql = " SELECT * FROM histclinica " . $condicion . " ORDER BY nro_hc DESC LIMIT 15"; //SELECT * FROM HISTORIACLINICA ORDER BY Nro_HC DESC LIMIT 15 WHERE Apepat = ?";
    }
    $consulta = $ConexionDB->query($sql);
    $fila = $consulta->fetchAll(PDO::FETCH_OBJ);

    ?>
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Historias Clínicas</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <form name=histclinica action="hc.php" method="POST">
                <div class="input-group forgroup">
                    <div class="col-md-1">
                        <a href="hcnuevo.php" class="btn btn-outline-primary">Nuevo</a>
                    </div>
                    <div class="col-md-11">

                    </div>
                </div>
                <hr>
                <div class="input-group form-group ">
                    <div class="col-md-7">
                        <input type="text" name="txtapepat" class="form-control" placeholder="Apellidos y nombres">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="txtdni" class="form-control" placeholder="Nro de Documento">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="txthc" class="form-control" placeholder="HC">
                    </div>
                    <div class="col-md-1">
                        <button type=submit name="buscar" class="btn btn-outline-success">Buscar</button>
                    </div>
                </div>
                <hr>
            </form>
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Nro de HC</th>
                            <th scope="col">Tipo Doc</th>
                            <th scope="col">NroDoc</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //while ($row = $sentencia->fetchObject()) {;
                        //if (!empty($ConexionDB)) :
                        //$sql = $ConexionDB->query("SELECT * FROM historiaclinica ORDER BY Nro_HC DESC LIMIT 15");
                        //$fila = $consulta->fetchAll(PDO::FETCH_OBJ);
                        foreach ($fila as $row) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $row->Nro_HC ?></th>
                                <td><?php echo $row->ID_Tipodoc ?></td>
                                <td><?php echo $row->NroDoc ?></td>
                                <td><?php echo $row->Nombres ?></td>
                                <td><?php echo $row->Sexo_Hc ?></td>
                                <td><?php echo $row->Estado ?></td>
                                <td>

                                    <a class="btn btn-outline-info" role="button" href="../Controllers/C_Hc.php?hc=<?php echo $row->Nro_HC ?>">PDF</a>
                                    <a class="btn btn-outline-warning" role="button" href="../Views/hcedit.php?Nro_HC=<?php echo $row->Nro_HC ?>">Edit</a>
                                    <!--<a class="btn btn-danger" href="../Models/M_hcelimina.php?Nro_HC=<?php echo $row->Nro_HC ?>" onclick="return confirm('Estas seguro?')">Eliminar</a>-->
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>