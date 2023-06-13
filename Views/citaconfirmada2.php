<div class="header">
    <?php
    date_default_timezone_set("America/Lima"); //Zona horaria de Peru
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
    $idhorario = $_POST['horario'];
    $orden = $_POST['Nro_orden'];
    $hc = $_POST['txthc'];

    /*if (empty($_POST['txthc']) && empty($_POST['txtdni'])) {
        header('Location: citapaciente2.php?nro=' . $idhorario);
        exit();
    } else {
        $hc = $_POST['txthc'];
    }*/

    $longitud = 8;
    $paciente = substr(str_repeat(0, $longitud) . $hc, -$longitud);

    $sqlhc = "SELECT * FROM HISTCLINICA WHERE nRO_HC='$paciente'";
    $consultahc = $ConexionDB->prepare($sqlhc);
    $consultahc->execute();
    $registrohc = $consultahc->fetchAll(PDO::FETCH_OBJ);
    foreach ($registrohc as $row) :
        $nrohc = $row->Nro_HC;
        $tipodoc = $row->ID_Tipodoc;
        $nrodoc = $row->NroDoc;
        $nombres = $row->Nombres;
        $sexo = $row->Sexo_Hc;
    endforeach;
    /*if (empty($nrohc)) {
        //header('Location: citapaciente.php?nro=' . $idhorario);
        echo "Historia clinica no existe <br>";
        echo '<a href="citapaciente2.php?nro=' . $idhorario . '&Nro_orden=' . $orden . '">Volver</a>';
        die();
    }*/
    $sql = "SELECT count(*) from CITAS WHERE Id_horario='$idhorario'";
    $cant = $ConexionDB->query($sql);
    $total = $cant->fetchColumn();
    $numerocupo = $total + 1;
    $numerocupo;

    $sql2 = "SELECT * from CITAS WHERE Id_horario='$idhorario'";
    $consulta2 = $ConexionDB->prepare($sql2);
    $consulta2->execute();
    $citas = $consulta2->fetchAll(PDO::FETCH_OBJ);
    foreach ($citas as $row) :
        $cita = $row->Nro_Cita;
        $cita = $cita + 1;
    endforeach;
    $sql3 = "SELECT * from CITAS WHERE Id_horario='$idhorario' and Nro_HC='$paciente'";
    $consulta3 = $ConexionDB->prepare($sql3);
    $consulta3->execute();
    $pacientes = $consulta3->fetchAll(PDO::FETCH_OBJ);
    foreach ($pacientes as $reg) :
        $nro_hc = $reg->Nro_HC;
        $hc = $reg->Nro_HC;
        $ord = $reg->orden;
        $horaini = $reg->horainicio;
        $horafi = $reg->horafin;
    endforeach;

    /*$sql6 = "SELECT * FROM CITAS WHERE Id_horario='$idhorario' and Nro_cita='$nrocita'";
    $consulta6 = $ConexionDB->query($sql6);
    $citas = $consulta6->fetchAll(PDO::FETCH_OBJ);
    foreach ($citas as $cita) :
        $hc = $cita->Nro_HC;
        $ord = $cita->orden;
        $horaini = $cita->horainicio;
        $horafi = $cita->horafin;
        $seguro = $cita->Id_cons*/

    if (!empty($nro_hc)) {

        echo "Historia clinica ya fue adicionada a la lista. Verifique <br>";
        echo '<a href=citapaciente2.php?Nro=' . $idhorario . '&hc=' . $hc . '&Nro_orden=' . $orden . '>Volver</a>';
        //header('Location: citapaciente.php?nro=' . $idhorario);
        //header('Location: citas.php');
        die();
    }

    $sql4 = "SELECT * FROM TURNOsXDIA WHERE Id_horario='$idhorario'";
    $consulta4 = $ConexionDB->prepare($sql4);
    $consulta4->execute();
    $turnosxdia = $consulta4->fetchAll(PDO::FETCH_OBJ);
    foreach ($turnosxdia as $row) :
        $idturno = $row->Id_Turno;
        $cuposdispo = $row->NroCupos;
        $adic = $row->Adicionales;
        $idcartera = $row->Id_cartera;
        $nrolargo = $row->Nro;
        $fechacita = $row->Fecha;
    endforeach;


    $sql5 = "SELECT cupos FROM carteracupos WHERE Id_cartera='$idcartera'";
    $consulta5 = $ConexionDB->query($sql5);
    $cupos = $consulta5->fetchColumn();

    $sql6 = "SELECT HORAINICIO_TURNO FROM TURNOS WHERE id_turno='$idturno'";
    $consulta6 = $ConexionDB->query($sql6);
    $horainicial = $consulta6->fetchColumn();


    $sql7 = "SELECT minxturno FROM CARTERASERV WHERE id_cartera='$idcartera'";
    $consulta7 = $ConexionDB->query($sql7);
    $minutos = $consulta7->fetchColumn();

    $sqlseguro = "SELECT id_condseguro from ordenlab where Nro_orden='$orden'";
    $consultaseguro = $ConexionDB->query($sqlseguro);
    $conseguro = $consultaseguro->fetchColumn();
    echo $orden;
    echo $conseguro;
    echo $minutos;
    die();
    $sql9 = "SELECT desc_seguro FROM condseguro WHERE id_condseguro='$conseguro'";
    $consulta9 = $ConexionDB->query($sql9);
    $condicionseguro = $consulta9->fetchColumn();

    $segundos = strtotime($horainicial);
    $segundosmin = ($minutos * 60) * $numerocupo;
    $horainicio = date("H:i:s", $segundos + $segundosmin);

    $segundosfin = strtotime($horainicio);
    $segundosminfin = $minutos * 60;
    $horafinal = date("H:i:s", $segundosfin + $segundosminfin);


    $sql8 = "INSERT INTO 
                citas (Id_horario, Nro_HC, orden, horainicio, horafin, Id_conseguro) 
                VALUE (?,?,?,?,?,?)";
    $consulta8 = $ConexionDB->prepare($sql8);
    $resultado = $consulta8->execute([$idhorario, $paciente, $numerocupo, $horainicio, $horafinal, $conseguro]);
    $cita = $ConexionDB->lastInsertId();
    //echo $cita;
    $nuevocupo = $cupos - $numerocupo;
    ////AQUÍ :  
    $sqlcita = "UPDATE ORDENLAB SET FechaCita=?  WHERE Nro_orden=?";
    $consultacita = $ConexionDB->prepare($sqlcita);
    $consultacita->execute([
        $fechacita, $orden
    ]);

    $iduser = $_SESSION['iduser'];
    $sql9 = "UPDATE TURNOSXDIA SET NroCupos=?, id_usuario=? WHERE Id_horario=?";
    $consulta9 = $ConexionDB->prepare($sql9);
    $consulta9->execute([$nuevocupo, $iduser, $idhorario]);



    if ($resultado) {
        $sql = "SELECT * FROM TURNOXDIA WHERE Id_horario='$idhorario'";
        $consulta = $ConexionDB->prepare($sql);
        $consulta->execute();
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);

        foreach ($registro as $row) :
            $cartera = $row->desc_cartera;
            $consultorio = $row->desc_consultorio;
            $prof = $row->Nombres_Prof;
            $fecha = $row->Fecha;
            $turno = $row->desc_turno;
        endforeach;
        /*$sql12="UPDATE ordenlab SET FechaCita=? WHERE Nro_orden=?";
                $consulta12 = $ConexionDB->prepare($sql12);
                $consulta12->execute([$nuevocupo, $idhorario]);*/
    }


    ?>

    <div class="input-group form-group">
        <div class="col-md-5">
            <b>Citas </b>
        </div>
        <div class="col-md-2"> </div>
        <div class="col-md-5"><b></b><?php echo ($_SESSION['nombre']);
                                        echo $_SESSION['iduser'] ?></b> </div>
    </div>
    <div class="card card-5">
        <div class="card-body">
            <?php
            echo "RESUMEN DE LA CITA <br>";
            echo "Nro de Cita : <b>" . $numerocupo . "</b><br>";
            echo "Fecha de atención : <b>" . $fecha . "</b><br>";
            echo "Turno : <b>" . $turno . "</b><br>";
            echo "Hora de Cita : <b>" . $horainicio . "</b><br>";
            echo "Servicio : <b>" .  $cartera . "</b><br>";
            echo "Consultorio : <b>" . $consultorio . "</b><br>";
            echo "Atendido por : <b>" . $prof . "</b><br>";
            echo "----------------------------------------------------------";
            echo "<br>Paciente : <b>" . $nombres . "</b><br>";
            echo "N° de Doc. : <b>" . $nrodoc . "</b><br>";
            echo "N° de HC : <b>" . $nrohc . "</b><br>";
            echo "Género : <b>" . $sexo . "</b><br>";
            echo "Condición de paciente : <b>" . $condicionseguro . "</b></br";
            echo "----------------------------------------------------------";
            //echo ($_SESSION['nombre']) . " -" . date('Y-m-d');
            ?>
            <hr>
            <div class="input-group forgroup">
                <div class="col-md-4">
                    <a href="../Views/ordenlabnew2.php" type="button" class="btn btn-outline-warning">Nueva Orden Laboratorio</a>

                </div>
                <div class="col-md-4">
                    <a href="../Views/ordenlab.php" type="button" class="btn btn-outline-info">Ingresar Resultado</a>
                </div>
                <div class="col-md-4">
                    <form name=HC method="GET" action="../Controllers/C_reporte2.php">
                        <input type=hidden name="horario" value="<?php echo $idhorario ?>">
                        <input type=hidden name="cita" value="<?php echo $cita ?>">
                        <button type=submit name="imprimir" class="btn btn-outline-success">Imprimir Cita</button>
                        <!--<a href="../Controllers/C_Cita.php?nro=<?php echo $idhorario ?>" type="button" class="btn btn-outline-info">Imprimir</a>-->
                    </form>
                </div>
            </div>
            <?php

            ?>
        </div>
        <?php

        ?>
    </div>
</div>
<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>