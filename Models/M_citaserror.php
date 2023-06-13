    <?php
    date_default_timezone_set("America/Lima"); //Zona horaria de Peru
    session_start();

    include_once('menu/header.php');

    if (!isset($_SESSION['nombre'])) {
        header:
        ('Location: ../index.php');
    } elseif (isset($_SESSION['nombre'])) {
        include_once('menu/menu.php');
        include_once('../Config/Conexion2.php');
    } else {
        echo "Error en el sistema";
    }

    $idhorario = $_POST['horario'];
    $nro = $_POST['txthc'];

    $longitud = 8;
    $paciente = substr(str_repeat(0, $longitud) . $nro, -$longitud);

    $sql = "SELECT count(*) from CITAS WHERE Id_horario='$idhorario'";
    $cant = $ConexionDB->query($sql);
    $total = $cant->fetchColumn();
    $numerocupo = $total + 1;
    $numerocupo;

    $sql1 = "SELECT * FROM TURNOsXDIA WHERE Id_horario='$idhorario'";
    $consulta1 = $ConexionDB->prepare($sql1);
    $consulta1->execute();
    $turnosxdia = $consulta1->fetchAll(PDO::FETCH_OBJ);
    foreach ($turnosxdia as $row) {
        $idturno = $row->Id_Turno;
        $cuposdispo = $row->NroCupos;
        $adic = $row->Adicionales;
        $idcartera = $row->Id_cartera;
    }

    $sql2 = "SELECT cupos FROM carteracupos WHERE Id_cartera='$idcartera'";
    $consulta = $ConexionDB->query($sql2);
    $cupos = $consulta->fetchColumn();

    $sql3 = "SELECT HORAINICIO_TURNO FROM TURNOS WHERE id_turno='$idturno'";
    $consulta = $ConexionDB->query($sql3);
    $horainicial = $consulta->fetchColumn();

    $sql4 = "SELECT minxturno FROM CARTERASERV WHERE id_cartera='$idcartera'";
    $consulta = $ConexionDB->query($sql4);
    $minutos = $consulta->fetchColumn();

    $segundos = strtotime($horainicial);
    $segundosmin = ($minutos * 60) * $numerocupo;
    $horainicio = date("H:i:s", $segundos + $segundosmin);


    $segundosfin = strtotime($horainicio);
    $segundosminfin = $minutos * 60;
    $horafinal = date("H:i:s", $segundosfin + $segundosminfin);


    $sql = "INSERT INTO 
            citas (Id_horario, Nro_HC, orden, horainicio, horafin) 
            VALUE (?,?,?,?,?)";
    $consulta = $ConexionDB->prepare($sql);
    $resultado = $consulta->execute([$idhorario, $paciente, $numerocupo, $horainicio, $horafinal]);

    $nuevocupo = $cupos - $numerocupo;
    $sql = "UPDATE TURNOSXDIA SET NroCupos=? WHERE Id_horario=?";
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute([$nuevocupo, $idhorario]);

    if ($resultado) {
        $correcto = true;
        $sql1 = "SELECT * FROM TURNOsXDIA WHERE Id_horario='$idhorario'";
        $consulta1 = $ConexionDB->prepare($sql1);
        $consulta1->execute();
        $turnosxdia = $consulta1->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) {
            echo "Cartera de Servicios: <b>" . $row->desc_cartera . '</b><br>';
            $cartera = $row->desc_cartera;
            echo "Consultorio:<b>" . $row->desc_consultorio . '</b><br>';
            $consultorio = $row->desc_consultorio;
            echo "Profesional:<b>" . $row->Nombres_Prof . '</b><br>';
            echo "Turno :<b>" . $row->desc_turno . '</b><br>';
        }
        echo "Numero de cita :" . $numerocupo . "<br>";
        echo "Hora de Cita : " . $horainicio;
    } else {
        $correcto = false;
        echo "NO se han insertado los datos";
        return;
    }
