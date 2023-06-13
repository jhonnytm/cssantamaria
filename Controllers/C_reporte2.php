<?php
date_default_timezone_set("America/Lima"); //Zona horaria de Peru
session_start();
//include('C_plantilla.php');
require '..//Public/fpdf/fpdf.php';
require('../Config/Conexion2.php');
$iduser = $_SESSION['iduser'];

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
    $user = $row->Id_usuario;
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

$sql6 = "SELECT NOMBRES FROM usuarios WHERE Id_usuario='$iduser'";
$consulta6 = $ConexionDB->query($sql6);
$usuario = $consulta6->fetchColumn();




$sql6 = "SELECT * FROM CITAS WHERE Id_horario='$idhorario' and nro_cita='$nrocita'";
$consulta = $ConexionDB->prepare($sql6);
$consulta->execute();
$citas = $consulta->fetchAll(PDO::FETCH_OBJ);
foreach ($citas as $row) {
    $hc = $row->Nro_HC;
    $horainicio = $row->horainicio;
    $horafin = $row->horafin;
    $orden = $row->orden;
    $idcondicion = $row->Id_conseguro;
}

$sql9 = "SELECT Desc_seguro FROM condseguro WHERE Id_CondSeguro='$idcondicion'";
$consulta9 = $ConexionDB->query($sql9);
$condicionseguro = $consulta9->fetchColumn();

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
$mensaje = "Para los pacientes con Prueba de:
    - GLUCOSA ----> Acudir en AYUNAS
    - ORINA ---------> Traer la primera muestra del día";
/*$sql8 = "SELECT * FROM condseguro WHERE Id_CondSeguro='$seguro'";
$consulta8 = $ConexionDB->query($sql8);
$registro8 = $consulta8->fetchAll(PDO::FETCH_OBJ);
foreach ($registro8 as $row8) :
    $nombreseguro = $row8->Desc_Seguro;
endforeach;*/

//$pdf = new Fpdf('P', 'mm', 'A4');
$pdf = new FPDF($orientation = 'P', $unit = 'mm', array(80, 350));
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 5);
$pdf->SetX(1);
$pdf->Cell(80, 5, utf8_decode('DIRECCIÓN DE REDES INTEGRADAS DE SALUD LIMA CENTRO'), 0, 1, 'C');
//$pdf->Cell(80, 5,utf8_decode( 'LIMA CENTRO'), 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->line(1, 15, 75, 15);
$pdf->SetX(1);
$pdf->Cell(80, 5, utf8_decode('CENTRO DE SALUD SANTA MARÍA'), 0, 1, 'C');
$pdf->line(1, 20, 75, 20);
$pdf->SetFont('Arial', '', 6);
$pdf->SetX(1);
$pdf->Cell(70, 5, 'RESUMEN DE LA CITA', 0, 1, 'L');
//$pdf->Ln(5);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetX(2);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(20, 7, 'Nro de Cita :', 0, 0, 'C', 1);
$pdf->Cell(25, 7, $orden, 0, 1, 'C', 1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, 'Fecha :', 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(45, 5, $fecha, 0, 1, 'L', 1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, 'Hora de Cita :', 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(45, 5, /*$horainicio*/ '08:00:00 A.M.', 0, 1, 'L', 1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, 'Turno :', 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(45, 5, utf8_decode($turno), 0, 1, 'L', 1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, 'Servicio :', 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(45, 5, utf8_decode($cartera), 0, 1, 'L', 1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, 'Consultorio :', 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(45, 5, utf8_decode($consultorio), 0, 1, 'L', 1);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(2);
$pdf->Cell(20, 5, 'Profesional :', 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(45, 5, utf8_decode($prof), 0, 1, 'L', 1);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetX(1);
$pdf->line(1, 62, 80, 62);
$pdf->ln(1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, 'Paciente :', 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(45, 5, utf8_decode($nombres), 0, 1, 'L', 1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, 'Nro de Doc:', 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(45, 5, $nrodoc, 0, 1, 'L', 1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, utf8_decode('Historia Clínica :'), 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(45, 5, $nrohc, 0, 1, 'L', 1);
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 5, utf8_decode('Condición :'), 0, 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(45, 5, $condicionseguro, 0, 1, 'L', 1);
$pdf->SetX(1);
$pdf->line(1, 84, 80, 84);
$fecha = date('Y-m-d h:i:s-A');
$pdf->Ln(2);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(40, 5, utf8_decode($usuario), 0, 0, 'C', 1);
$pdf->Cell(40, 5, $fecha, 0, 1, 'C', 1);
$pdf->Ln(2);
$pdf->SetX(1);
$pdf->line(1, 91, 80, 91);
$pdf->SetX(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(80, 5, 'RECOMENDACIONES:', 0, 1, 'L');
$pdf->SetX(2);
$pdf->SetFont('Arial', '', 6);
$pdf->multiCell(80, 5, utf8_decode($mensaje), 0, 1, 'L');
$pdf->SetX(2);
$pdf->Cell(80, 5, 'Acudir 10 minutos antes de la hora pactada', 0, 1, 'L');
$pdf->SetX(1);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(80, 5, utf8_decode('AV. HÉROES DEL CENEPA MZ D S/LOTE AAHH SANTA MARÍA'), 0, 1, 'C');
$pdf->Ln(10);
$pdf->Output(utf8_decode($nombres) . '.pdf', 'D');
