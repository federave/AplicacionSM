<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/trabajadores/trabajador.php');
include($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/diaRepartidor.php');


$idRepartidor  = $_GET["idRepartidor"];
$repartidor = new Trabajador($idRepartidor);
$fecha = $_GET["fecha"];
$diaRepartidor = new DiaRepartidor();

$diaRepartidor->setRepartidor($repartidor);
$diaRepartidor->setFecha($fecha);

$aux = $diaRepartidor->cargar();

$xml = new Xml();
$xml->startTag("Balance");
$xml->addTag("Estado",$aux);

if($aux)
  {
  $xml->addTag("Bidones20L",$diaRepartidor->getBalanceBidones20L());
  $xml->addTag("Bidones12L",$diaRepartidor->getBalanceBidones12L());
  $xml->addTag("Bidones10L",$diaRepartidor->getBalanceBidones10L());
  $xml->addTag("Bidones8L",$diaRepartidor->getBalanceBidones8L());
  $xml->addTag("Bidones5L",$diaRepartidor->getBalanceBidones5L());
  $xml->addTag("PackBotellas2L",$diaRepartidor->getBalancePackBotellas2L());
  $xml->addTag("PackBotellas500mL",$diaRepartidor->getBalancePackBotellas500mL());
  $xml->addTag("Bidones20LVacios",$diaRepartidor->getBalanceBidones20LVacios());
  $xml->addTag("Bidones12LVacios",$diaRepartidor->getBalanceBidones12LVacios());

  }
$xml->closeTag("Balance");

echo $xml->toString();


?>
