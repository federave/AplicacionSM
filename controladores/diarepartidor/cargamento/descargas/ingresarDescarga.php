<?php
include_once('../../../../otros/otros.php');
include_once('../../../../modelo/conector.php');
include_once('../../../../modelo/diaRepartidor/cargamento/descargas/descarga.php');
include_once('../../../../modelo/diaRepartidor/cargamento/descargas/descargas.php');
include_once('../../../../modelo/trabajadores/trabajador.php');


$idRepartidor  = $_GET["idRepartidor"];
$repartidor  = new Trabajador($idRepartidor);
$fecha = $_GET["fecha"];
$descarga = new Descarga();

$descarga->setRepartidor($repartidor);
$descarga->setFecha($fecha);

$descarga->getRetornables()->setBidon20L($_GET["bidones20L"]);
$descarga->getRetornables()->setBidon12L($_GET["bidones12L"]);
$descarga->getRetornablesVacios()->setBidon20L($_GET["bidones20LVacios"]);
$descarga->getRetornablesVacios()->setBidon12L($_GET["bidones12LVacios"]);
$descarga->getDescartables()->setBidon10L($_GET["bidones10L"]);
$descarga->getDescartables()->setBidon8L($_GET["bidones8L"]);
$descarga->getDescartables()->setBidon5L($_GET["bidones5L"]);
$descarga->getDescartables()->setPackBotellas2L($_GET["packBotellas2L"]);
$descarga->getDescartables()->setPackBotellas500mL($_GET["packBotellas500mL"]);

$aux = $descarga->guardar();


$xml = new Xml();
$xml->startTag("RespuestaIngresarDescarga");
if($aux)
  {
  $xml->addTag("Estado",$aux);
  }
else
  {
  $xml->addTag("Estado",$aux);
  }
$xml->closeTag("RespuestaIngresarDescarga");


echo $xml->toString();



?>
