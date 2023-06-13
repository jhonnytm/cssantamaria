<?php
ob_start();

?>
<div class="header">
    <?php
    session_start();
    include_once('../views/menu/header.php');
    if (!isset($_SESSION['nombre'])) {
        header:
        ('Location: ../index.php');
    } elseif (isset($_SESSION['nombre'])) {
        include_once('../Config/Conexion2.php');
    } else {
        echo "Error en el sistema";
    }
    ?>
</div>
<div class="container">
    <?php

    $idhorario = $_GET['horario'];
    $nrocita = $_GET['cita'];

    //echo $idhorario . $nrocita;
    //die();
    if (empty($_GET['cita'])) {

        //$nrocita = "";
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
    $consulta = $ConexionDB->prepare($sql6);
    $consulta->execute();
    $citas = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($citas as $row) {
        $hc = $row->Nro_HC;
        $horainicio = $row->horainicio;
        $horafin = $row->horafin;
        $orden = $row->orden;
    }

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
    <h2>Citas</h2>
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
                        <td>Servicio:</td>
                        <th scope="row"><?php echo $cartera ?></th>
                    </tr>
                    <tr>
                        <td>Consultorio :</td>
                        <th scope="row"><?php echo $consultorio ?></th>
                    </tr>
                    <tr>
                        <td>Fecha :</td>
                        <th scope="row"><?php echo $fecha ?></th>
                    </tr>
                    <tr>
                        <td>Turno :</td>
                        <th scope="row"><?php echo $turno ?></th>
                    </tr>
                    <tr>
                        <td>Nro de Cita :</td>
                        <th scope="row"><?php echo $orden ?></th>
                    </tr>
                    <tr>
                        <td>Hora Cita:</td>
                        <th scope="row"><?php echo $horainicio ?></th>
                    </tr>

                    <tr>
                        <td>Paciente :</td>
                        <th scope="row"><?php echo $nombres ?></th>
                    </tr>
                    <tr>
                        <td>Nro de Documento :</td>
                        <th scope="row"><?php echo $nrodoc ?></th>
                    </tr>
                    <tr>
                        <td>Historia clínica :</td>
                        <th scope="row"><?php echo $nrohc ?></th>
                    </tr>
                    <tr>
                        <td>Sexo :</td>
                        <th scope="row"><?php echo $sexo ?></th>
                    </tr>
                    <tr>
                        <td>Profesional que lo atenderá :</td>
                        <th scope="row"><?php echo $prof ?></th>
                    </tr>

                </tbody>
            </table>

            <table class="table table-sm">
                <tr>

                    <td><?php echo ($_SESSION['nombre']); ?></td>
                    <td><?php echo date('Y-m-d'); ?></td>
                </tr>

            </table>
            <hr>
        </div>

    </div>
    <?php
    $nrocita = "";


    $html = ob_get_clean();

    include '..//Public/dompdf/autoload.inc.php';

    use Dompdf\Dompdf;
    use Illuminate\Mail\Mailables\Attachment;

    $dompdf = new Dompdf();

    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);

    $dompdf->loadHtml("$html");
    //$dompdf->setPaper('letter');
    $dompdf->setpaper("A4", "portrait");

    $dompdf->load_html(utf8_decode($html));

    $dompdf->render();
    $dompdf->stream("hc.pdf", array("Attachment" => true));

    ?>