<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');
include_once('../modelo/precios/precios.php');


function precios(&$xml,$fecha)
{

$precioAlquileres = new PrecioAlquileres($fecha);
$precioRetornables = new PrecioRetornables($fecha);
$precioDescartables = new PrecioDescartables($fecha);
$precioDispensadores = new PrecioDispensadores($fecha);

$xml->startTag("Precios");
  $xml->startTag("PrecioDispensadores");
    $xml->addTag("Vertedor_Precio",$precioDispensadores->getVertedor());
    $xml->addTag("Dispenser_Precio",$precioDispensadores->getDispenser());
  $xml->closeTag("PrecioDispensadores");
  $xml->startTag("PrecioAlquileres");
    $xml->addTag("Alquiler6Bidones_Precio",$precioAlquileres->getAlquiler6Bidones());
    $xml->addTag("Alquiler8Bidones_Precio",$precioAlquileres->getAlquiler8Bidones());
    $xml->addTag("Alquiler10Bidones_Precio",$precioAlquileres->getAlquiler10Bidones());
    $xml->addTag("Alquiler12Bidones_Precio",$precioAlquileres->getAlquiler12Bidones());
  $xml->closeTag("PrecioAlquileres");
  $xml->startTag("PrecioRetornables");
    $xml->addTag("Bidon20L_Precio",$precioRetornables->getBidon20L());
    $xml->addTag("Bidon12L_Precio",$precioRetornables->getBidon12L());
  $xml->closeTag("PrecioRetornables");
  $xml->startTag("PrecioDescartables");
    $xml->addTag("Bidon10L_Precio",$precioDescartables->getBidon10L());
    $xml->addTag("Bidon8L_Precio",$precioDescartables->getBidon8L());
    $xml->addTag("Bidon5L_Precio",$precioDescartables->getBidon5L());
    $xml->addTag("PackBotellas2L_Precio",$precioDescartables->getPackBotellas2L());
    $xml->addTag("PackBotellas500mL_Precio",$precioDescartables->getPackBotellas500mL());
  $xml->closeTag("PrecioDescartables");
$xml->closeTag("Precios");



}

//////// lo que se ejecuta


$fecha = $_GET["fecha"];
$xml = new Xml();
precios($xml,$fecha);
echo $xml->toString();

?>
