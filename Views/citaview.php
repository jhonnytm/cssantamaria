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
<?php
$idhorario = $_GET['horario'];
$nrocita = $_GET['cita'];

if (empty($_GET['cita'])) {
    header('Location: citapaciente.php?nro=' . $idhorario);
    exit();
}

$sql1 = "SELECT * FROM TURNOsXDIA WHERE Id_horario='$idhorario'";
$consulta1 = $ConexionDB->prepare($sql1);
$consulta1->execute();
$turnosxdia = $consulta1->fetchAll(PDO::FETCH_OBJ);
foreach ($turnosxdia as $row) {
    $fecha = $row->Fecha;
    $idcartera = $row->Id_cartera;
    $idconsultorio = $row->Id_consultorio;
    $idprof = $row->Id_Prof;
    $idturno = $row->Id_Turno;
}

$sql2 = "SELECT DESC_CARTERA FROM CARTERASERV WHERE ID_CARTERA='$idcartera'";
$consulta = $ConexionDB->query($sql2);
$cartera = $consulta->fetchColumn();

$sql4 = "SELECT DESC_CONSULTORIO FROM CONSULTORIOS WHERE ID_CONSULTORIO='$idconsultorio'";
$consulta = $ConexionDB->query($sql4);
$consultorio = $consulta->fetchColumn();

$sql3 = "SELECT DESC_TURNO FROM TURNOS WHERE id_turno='$idturno'";
$consulta = $ConexionDB->query($sql3);
$turno = $consulta->fetchColumn();

$sql5 = "SELECT NOMBRES_PROF FROM PROFESIONALES WHERE Id_prof='$idprof'";
$consulta = $ConexionDB->query($sql5);
$prof = $consulta->fetchColumn();

$sql6 = "SELECT * FROM CITAS WHERE Id_horario='$idhorario' and Nro_cita='$nrocita'";
$consulta = $ConexionDB->query($sql6);
//$consulta->execute();
$citas = $consulta->fetchAll(PDO::FETCH_OBJ);
foreach ($citas as $row) {
    $hc = $row->Nro_HC;
    $horainicio = $row->horainicio;
    $horafin = $row->horafin;
    $orden = $row->orden;
    $seguro = $row->Id_conseguro;
}

$sql8 = "SELECT DESC_Seguro FROM condseguro WHERE Id_condseguro='$seguro'";
$consulta8 = $ConexionDB->query($sql8);
$condseguro = $consulta8->fetchColumn();

$sql7 = "SELECT * FROM HISTCLINICA WHERE NRO_HC='$hc'";
$consulta = $ConexionDB->prepare($sql7);
$consulta->execute();
$hist = $consulta->fetchAll(PDO::FETCH_OBJ);
foreach ($hist as $row) {
    $nrohc = $row->Nro_HC;
    $nombres = $row->Nombres;
    $sexo = $row->Sexo_Hc;
    $nrodoc = $row->NroDoc;
}
?>
<div class="container">
    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Citas</b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b><?php echo ($_SESSION['nombre']) ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="colspan 2">Resumen de la cita :</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nro de Cita :</td>
                        <th scope="row"><?php echo $orden ?></th>
                        <td>Fecha :</td>
                        <th scope="row"><?php echo $fecha ?></th>
                    </tr>
                    <tr>
                        <td>Hora Cita:</td>
                        <th scope="row"><?php echo $horainicio ?></th>
                        <td>Turno :</td>
                        <th scope="row"><?php echo $turno ?></th>
                    </tr>
                    <tr>
                        <td>Servicio:</td>
                        <th scope="row"><?php echo $cartera ?></th>
                        <td>Consultorio :</td>
                        <th scope="row"><?php echo $consultorio ?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <th scope="row"></th>
                        <td>Profesional que lo atenderá :</td>
                        <th scope="row"><?php echo $prof ?></th>
                    </tr>
                    <tr>
                        <td>Paciente :</td>
                        <th scope="row"><?php echo $nombres ?></th>

                    </tr>
                    <tr>
                        <td>Nro de Documento :</td>
                        <th scope="row"><?php echo $nrodoc ?></th>
                        <td>Historia clínica :</td>
                        <th scope="row"><?php echo $nrohc ?></th>
                    </tr>
                    <tr>

                        <td>Sexo :</td>
                        <th scope="row"><?php echo $sexo ?></th>
                        <td>Condición de ingreso:</td>
                        <th scope="row"><?php echo $condseguro ?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php //echo ($_SESSION['nombre']); 
                            ?> - <?php echo date('Y-m-d H:i:s'); ?></td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <div class="input-group forgroup">
                <div class="col-md-1">

                </div>
                <div class="col-md-3">
                    <a href="../Views/citapacientebusca.php?nro=<?php echo $idhorario; ?>" type="button" class="btn btn-outline-warning">Ver Listado</a>
                </div>
                <div class="col-md-3">
                    <a href="../Views/citas.php" type="button" class="btn btn-outline-success">Otra fecha</a>
                </div>
                <div class="col-md-3">
                    <a href="../Views/hc.php" type="button" class="btn btn-outline-info">Imprimir FUA</a>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-outline-primary" role="button" href="../Controllers/C_reporte1.php?horario=<?php echo $idhorario ?>&cita=<?php echo $nrocita ?>">Imprimir Cita</a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>