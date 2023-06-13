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
$sql = "SELECT * FROM eess ORDER BY desc_eess asc LIMIT 25";

if (isset($_POST['buscar'])) {
    $nombre = $_POST['txtnombre'];
    $cod = $_POST['txtcod'];

    $longitud = 4;
    $cod = substr(str_repeat(0, $longitud) . $cod, -$longitud);

    if (($_POST['txtnombre'] == "") && ($_POST['txtcod'] == "")) {
        $condicion = "";
    } elseif (!empty($nombre)) {
        $condicion = "WHERE desc_eess like '%" . $nombre . "%'";
    } elseif (!empty($cod)) {
        $condicion = "WHERE id_eess ='" . $cod . "'";
    }
    $sql = " SELECT * FROM eess " . $condicion . " ORDER BY desc_eess asc LIMIT 25";
}
$consulta = $ConexionDB->query($sql);
$fila = $consulta->fetchAll(PDO::FETCH_OBJ);
?>
<div class="container">
    <div class="input-group form-group">
        <div class="col-md-4">
            <b>Establecimientos de salud</b>
        </div>
        <div class="col-md-5"> </div>
        <div class="col-md-3"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>

    <div class="card card-5">
        <div class="card-body">
            <form name=eess action="eess.php" method="POST">
                <div class="input-group forgroup">
                    <div class="col-md-1">
                        <a href="eessnew.php" class="btn btn-outline-primary">Nuevo</a>
                    </div>
                    <div class="col-md-11">

                    </div>
                </div>
                <hr>
                <div class="input-group form-group ">
                    <div class="col-md-7">
                        <input type="text" name="txtnombre" class="form-control" placeholder="Apellidos y nombres">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="txtcod" class="form-control" placeholder="Nro de Documento">
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
                            <th scope="col">Código Renaes</th>
                            <th scope="col">Código Aux</th>
                            <th scope="col">Desc_EESS</th>
                            <th scope="col">RIS</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Nivel</th>
                            <th scope="col">Distrito</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($fila as $row) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $row->Id_EESS ?></th>
                                <td><?php echo $row->CodAux_EESS ?></td>
                                <td><?php echo $row->Desc_EESS ?></td>
                                <td><?php echo $row->Cod_Ris ?></td>
                                <td><?php echo $row->Categ_EESS ?></td>
                                <td><?php echo $row->Nivel_EESS ?></td>
                                <td><?php echo $row->Id_Dist ?></td>
                                <td>

                                    <a class="btn btn-outline-info" role="button" href="../Controllers/C_eess.php?eess=<?php echo $row->Nro_HC ?>">view</a>
                                    <a class="btn btn-outline-warning" role="button" href="../Views/C_eess.php?EESS=<?php echo $row->Nro_HC ?>">Edit</a>
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