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
<?php
$sql = "SELECT * FROM profesionales ORDER BY nombres_prof asc LIMIT 15";

if (isset($_POST['buscar'])) {
    $apepat = $_POST['txtapepat'];
    $doc = $_POST['txtdni'];

    $longitud = 8;
    $doc = substr(str_repeat(0, $longitud) . $doc, -$longitud);

    if (($apepat == "") && ($doc == "")) {
        $condicion = "";
    } elseif (!empty($apepat)) {
        $condicion = "WHERE nombres_prof like '" . $apepat . "%'";
    } elseif (!empty($doc)) {
        $condicion = "WHERE NroDoc_prof ='" . $doc . "'";
    }
    $sql = " SELECT * FROM profesionales " . $condicion . " ORDER BY nombres_prof asc LIMIT 15";
}
$consulta = $ConexionDB->query($sql);
$fila = $consulta->fetchAll(PDO::FETCH_OBJ);
?>
<div class="container">
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Profesionales</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>

    <div class="card card-5">
        <div class="card-body">
            <form name=profesionales action="profesionales.php" method="POST">
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
                            <th scope="col">Tipo Doc</th>
                            <th scope="col">NroDoc</th>
                            <th scope="colspan=3">Nombres</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Fecha de nac</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($fila as $row) {
                        ?>
                            <tr>
                                <th scope="row"></th><?php echo $row->Id_tipoDoc ?></td>
                                <td><?php echo $row->NroDoc_Prof ?></td>
                                <td><?php echo $row->Nombres_Prof ?></td>
                                <td><?php echo $row->Sexo_Prof ?></td>
                                <td><?php echo $row->FechaNac_Prof ?></td>
                                <td>

                                    <a class="btn btn-outline-info" role="button" href="../Controllers/C_profesionales.php?hc=<?php echo $row->Nro_HC ?>">view</a>
                                    <a class="btn btn-outline-warning" role="button" href="../Views/C_profesionales.php?Nrodocprof=<?php echo $row->Nro_HC ?>">Edit</a>
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
<div class=footer id footer>
    <?php include_once('menu/footer.php'); ?>
</div>