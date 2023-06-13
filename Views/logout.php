<?php

include_once("../Config/sesiones.php");

$userSession = new UserSession();
$userSession->closeSession();


header("location: ../index.php");
