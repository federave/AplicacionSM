<?php
include_once('../modelo/trabajadores/repartidores.php');
include_once('../otros/otros.php');

$repartidores = new Repartidores();

$xml = new Xml();
$xml->startTag("Repartidores");

$k=0;
while($k <   $repartidores->getNumeroRepartidores())
    {
    $repartidor = $repartidores->getRepartidor($k);
    $xml->startTag("Repartidor");
      $xml->addTag("Id",$repartidor->getId());
      $xml->addTag("Nombre",$repartidor->getNombre());
      $xml->addTag("Apellido",$repartidor->getApellido());
      $xml->addTag("Dni",$repartidor->getDni());
    $xml->closeTag("Repartidor");
    $k++;
    }

$xml->closeTag("Repartidores");


echo $xml->toString();
?>
