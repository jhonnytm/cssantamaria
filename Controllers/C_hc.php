<?php
ob_start();

?>
<div class="header">
    <?php
    session_start();

    include_once('..//Views/menu/header.php');
    //include_once('../CsSantaMaria/Views/menu/menu.php');
    if (!isset($_SESSION['nombre'])) {
        header:
        ('Location: ../index.php');
    } elseif (isset($_SESSION['nombre'])) {
        include_once('..//Views/menu/header.php');
        include_once('../Config/Conexion2.php');
    } else {
        echo "Error en el sistema";
    }
    ?>
</div>
<?php
//include_once('../Config/Conexion2.php');

$hc = $_GET['hc'];

$sql = "SELECT * from HISTORIACLINICA WHERE NRO_HC='$hc'";
$consulta = $ConexionDB->prepare($sql);
$consulta->execute();
$registros = $consulta->fetchAll(PDO::FETCH_OBJ);
foreach ($registros as $registro) :
    $hc = $registro->Nro_HC;
    $tipodoc = $registro->Id_TipoDoc;
    $nrodoc = $registro->NroDoc;
    $nombres = $registro->Nombres_HC;
    $apellidos = $registro->Apepat_HC . " " . $registro->Apemat_HC;
    $sexo = $registro->Sexo_HC;
    $fechanac = $registro->FechaNac_HC;
    $celular = $registro->Celular_HC;
    $direccion = $registro->Direccion_HC;
    $estadociv = $registro->EstadoCivil;
endforeach;
?>

<div class=container>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" colspan=4>HISTORIA CLÍNICA</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Historia clínica :</td>
                <th scope="row"><?php echo $hc ?></th>
                <td>Archivo Clínico :</td>
                <th scope="row"><?php echo $nrodoc ?></th>

            </tr>
            <tr>
                <td>Tipo de Doc:</td>
                <th scope="row"><?php echo $tipodoc ?></th>
                <td>Nro de Doc:</td>
                <th scope="row"><?php echo $nrodoc ?></th>
            </tr>
            <tr>
                <td>Apellidos :</td>
                <th scope="row"><?php echo $apellidos ?></th>
                <td>Nombres:</td>
                <th scope="row"><?php echo $nombres ?></th>
            </tr>
            <tr>
                <td>Sexo :</td>
                <th scope="row"><?php echo $sexo ?></th>
                <td>Fecha de Nac:</td>
                <th scope="row"><?php echo $fechanac ?></th>
            </tr>
            <tr>
                <td>Dirección :</td>
                <th scope="row" colspan="3"><?php echo $direccion ?></th>



            </tr>
            <tr>
                <td>Estado Civil :</td>
                <th scope="row"><?php echo $estadociv ?></th>
                <td>Celular :</td>
                <th scope="row"><?php echo $celular ?></th>
            </tr>
        </tbody>
    </table>

</div>
<div class="footer" id="footer">
    <?php include_once('..//Views/menu/footer.php'); ?>
</div>
<?php
$html = ob_get_clean();

include '..//Public/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Illuminate\Mail\Mailables\Attachment;

$dompdf = new Dompdf();
/*$dompdf->loadHtml(ob_get_clean());
$dompdf->render();
$dompdf->stream();*/

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml("$html");
//$dompdf->setPaper('letter');
$dompdf->setpaper('A4', 'landscape');

$dompdf->render();
$dompdf->stream("hc.pdf", array("Attachment" => true));

?>