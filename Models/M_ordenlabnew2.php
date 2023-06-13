    <?php
    date_default_timezone_set("America/Lima"); //Zona horaria de Peru
    session_start();
    include_once('../Config/Conexion2.php');

    $fechaactual = date('Ymd');
    $fechafiltro = date('Y-m-d');
    $mifecha = date('Y-m-d H:i:s');

    $hc = $_POST['nrohc'];
    $doc = $_POST['nrodoc'];

    if (empty($_POST['nrodoc']) and empty($_POST['nrohc'])) {

        header('Location: ../Views/ordenlabnew2.php');
        exit();
    } elseif (!empty($_POST['nrohc'])) {
        $longitud = 8;
        $nrohc = substr(str_repeat(0, $longitud) . $hc, -$longitud);
        $condicion = " WHERE NRO_HC";
    } else {
        $longitud = 8;
        $nrohc = substr(str_repeat(0, $longitud) . $doc, -$longitud);
        $condicion = " WHERE NRODOC";
    }

    $sqlbusca = "SELECT * FROM HISTCLINICA " . $condicion . "='$nrohc'";
    //echo $sqlbusca;

    $consulta = $ConexionDB->query($sqlbusca);
    $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
    foreach ($registro as $row) :
        $encuentra = $row->Nombres;
        $nrohc = $row->Nro_HC;
        $nrodoc = $row->NroDoc;
    endforeach;


    if (empty($encuentra)) {
        //header('Location: ../Views/ordenlabnew.php');
        header('Location: ../Views/hcnuevo.php');
    } else {
        $sql = "SELECT COUNT(*) FROM ORDENLAB WHERE date(Fecharegistro)='$fechafiltro'";
        $cant = $ConexionDB->query($sql);
        $total = $cant->fetchColumn();
        $nro = $total + 1;

        $longitud = 4;
        $nroorden = substr(str_repeat(0, $longitud) . $nro, -$longitud);
        $nroordenlab = $fechaactual . $nroorden;

        $sqlbusca = "SELECT * FROM HISTCLINICA " . $condicion . "='$nrohc'";
        echo $sqlbusca;

        $consulta = $ConexionDB->query($sqlbusca);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $reg) :
            echo $encuentra = $reg->Nombres;
            echo $sexo = $reg->Sexo_Hc;
            echo $nrodoc = $reg->NroDoc;
            echo $hc = $reg->Nro_HC;
        endforeach;

        //if(){

        //}
        header('Location: ../views/ordenlabnew3.php?nrohc=' . $nrohc . '&nrodoc=' . $nrodoc);
    }
    //header('Location: ../Views/ordenlabview2.php');
