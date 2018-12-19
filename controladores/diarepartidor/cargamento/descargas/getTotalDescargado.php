<?php

include_once('../../../../modelo/diaRepartidor/cargamento/descargas/descargas.php');
include_once('../../../../modelo/trabajadores/trabajador.php');


$idRepartidor  = $_GET["idRepartidor"];
$repartidor  = new Trabajador($idRepartidor);
$fecha = $_GET["fecha"];

$descargas = new Descargas();
$descargas->setRepartidor($repartidor);
$descargas->setFecha($fecha);
$descargas->cargar();
echo $descargas->toString();


?>
