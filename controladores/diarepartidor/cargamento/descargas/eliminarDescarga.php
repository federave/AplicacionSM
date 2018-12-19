<?php
include_once('../../../../modelo/diaRepartidor/cargamento/descargas/descarga.php');
include_once('../../../../otros/otros.php');

$idDescarga  = $_GET["idDescarga"];
$descarga = new Descarga($idDescarga);
$aux = $descarga->eliminar();

$xml = new Xml();
$xml->startTag("RespuestaEliminarDescarga");
if($aux)
  {
  $xml->addTag("Estado",$aux);
  }
else
  {
  $xml->addTag("Estado",$aux);
  }
$xml->closeTag("RespuestaEliminarDescarga");


echo $xml->toString();



?>
