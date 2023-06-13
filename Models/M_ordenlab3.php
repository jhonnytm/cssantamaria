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
    /*session_start();
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
require_once('../Config/Conexion2.php');*/
    $fechaactual = date('Y-m-d');
    if (isset($_GET['fecha'])) {
        //echo "bien";
        $fecha = $_GET['fecha'];
        $sql = " SELECT * FROM ordenhistprof where Fechacita='$fecha' ";
        $consulta = $ConexionDB->query($sql);
        $filas = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($filas as $registro) :
            $nroorden = $registro->Nro_orden;
            $nroordenlab = $registro->NroOrdenLab;
            $fechaemision = $registro->FechaEmision;
            $estado = $registro->Estado;
            $nrodoc = $registro->NroDoc;
            $paciente = $registro->Paciente;
            $seguro = $registro->Desc_Seguro;
            $nrorecibo = $registro->Nrorecibofua;
            $estrategia = $registro->Desc_EstrategiaS;
            $prof = $registro->Nombres_Prof;
            $fechacita = $registro->FechaCita;
            $fechatermino = $registro->FechaTermino;
        endforeach;

        $sqlp = "SELECT * FROM ORDENLAB WHERE FechaCita='$fecha'";
        $consultap = $ConexionDB->prepare($sqlp);
        $consultap->execute();
        $registrop = $consultap->fetchAll(PDO::FETCH_OBJ);
        foreach ($registrop as $rowp) :
            $orden = $rowp->Nro_orden;
            $nroordenlab = $rowp->NroOrdenLab;
            $nrohc = $rowp->Nro_HC;
            $fechaemision = $rowp->FechaEmision;
            $prof = $rowp->Id_Prof;
            $estrategia = $rowp->Id_EstrategiaS;
            $seguro = $rowp->Id_CondSeguro;
            $nrorecibofua = $rowp->Nrorecibofua;
            $fecharegistro = $rowp->FechaRegistro;
            $estado = $rowp->Estado;
            $fechatermino = $rowp->FechaTermino;
            $fechaimpresion = $rowp->Fechaimpresion . '<br>';
        endforeach;


        $sql1 = "SELECT * FROM HISTCLINICA WHERE nRO_hC='$nrohc'";
        $consulta = $ConexionDB->query($sql1);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $nombrespaciente = $row->Nombres;
            $sexo = $row->Sexo_Hc;
            $fechanac = $row->FechaNac_HC;
            $celular = $row->Celular_hc;
            $nrodoc = $row->NroDoc;
        endforeach;

        $fechainicio = strtotime(date('Y-m-d'));
        $fechafin = strtotime($fechanac);
        $fechas = round(($fechainicio - $fechafin) / 31536000, 1);
        $decimalanio = explode(".", $fechas);
        $anio = $decimalanio[0] . " Años ";
        //$mess = round(($decimalanio[1] * 12) / 10, 1);
        //$decimalmes = explode(".", $mess);
        //$mes = $decimalmes[0] . " meses ";
        $edad = $anio; //. $mes;

        $sql = "SELECT * FROM profesionales WHERE Id_prof='$prof'";
        $consulta = $ConexionDB->query($sql);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $nombresprof = $row->Nombres_Prof;
        endforeach;

        $sql = "SELECT * FROM estrasanitaria WHERE Id_estrategias='$estrategia'";
        $consulta = $ConexionDB->query($sql);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $nombreestrategia = $row->Desc_EstrategiaS;
        endforeach;

        $sql = "SELECT * FROM condseguro WHERE Id_CondSeguro='$seguro'";
        $consulta = $ConexionDB->query($sql);
        $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
        foreach ($registro as $row) :
            $nombreseguro = $row->Desc_Seguro;
        endforeach;
        /*$impreso = "SI";
    $sql = "UPDATE ORDENLAB 
        SET 
        Impreso=?, FechaImpresion=? 
        WHERE Nro_orden=?";
    $consulta = $ConexionDB->prepare($sql);
    $consulta->execute([$impreso, $fechaimpresion, $ordenlab]);*/
    ?>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>


                            <th scope="col">Nro orden</th>
                            <th scope="col">ordenlab</th>
                            <th scope="col">fecha emision</th>
                            <th scope="col">Paciente</th>>
                            <th scope="col">profesional</th>
                            <th scope="col">condicion</th>
                            <th scope="col">recibo</th>
                            <th scope="col">estrategia</th>

                            <th scope="col">Fecha termino</th>
                            <th scope="col">estado</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($ConexionDB)) {
                            foreach ($filas as $registro) :
                        ?>
                                <tr>
                                    <td><?php echo $nroordenn = $registro->Nro_orden
                                        ?>
                                    </td>
                                    <td><?php echo $registro->NroOrdenLab ?></td>
                                    <td><?php echo $registro->FechaEmision; ?></td>
                                    <!--<td><?php //echo $registro->NroDoc 
                                            ?></td>-->
                                    <td><?php echo $registro->Paciente ?></td>
                                    <td><?php echo $registro->Nombres_Prof ?></td>
                                    <td><?php echo $registro->Desc_Seguro ?></td>
                                    <td><?php echo $registro->Nrorecibofua ?></td>
                                    <td><?php echo $registro->Desc_EstrategiaS ?></td>
                                    <td><?php echo $registro->FechaTermino ?></td>
                                    <td><?php if (($registro->Estado) === "PENDIENTE") {
                                            echo '<font color=red>' . $registro->Estado . '</font>';
                                        } else {
                                            echo '<font color=blue>' . $registro->Estado . '</font>';
                                        } ?></td>
                                    <td><?php
                                        echo "<b>Exámenes solicitados :</b>" . '<br>';
                                        $sqldet = "SELECT * FROM ORDENLABEXAMENES WHERE Nro_orden='$nroordenn'";
                                        $consultdet = $ConexionDB->prepare($sqldet);
                                        $consultdet->execute();
                                        $registrodet = $consultdet->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($registrodet as $filadet) :
                                            echo $filadet->Desc_examen;
                                            echo $filadet->muestra_uno . '<br>';
                                        endforeach;
                                        ?></td>
                                </tr><?php
                                    endforeach;
                                } else {
                                        ?>
                            <tr>
                                <td> No existen registros</td>
                            </tr>
                        <?php }
                        ?>
                </table>
            </div>
        </div>
    <?php
    } else {
        echo "no";
    }
    die();
    ?>
</div>
<div class="footer" id="footer">
    <?php include_once('menu/footer.php'); ?>
</div>