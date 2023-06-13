<?php

function calcularanios($fecini, $fecfin)
{
    $fechainicio = strtotime($fecini);
    $fechafin = strtotime($fecfin);

    $fechas = round(($fechainicio - $fechafin) / 31536000, 1);
    $decimalanio = explode(".", $fechas);
    $anio = $decimalanio[0] . " Años ";
    $mess = round(($decimalanio[1] * 12) / 10, 1);
    $decimalmes = explode(".", $mess);
    $mes = $decimalmes[0] . " meses ";
    $edad = $anio . $mes;
    return $edad;
}
