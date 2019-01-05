<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');
include_once('../../modelo/precios/precios.php');
include_once('precioProductos.php');
include_once('datosCliente.php');
$fecha = $_GET["fecha"];
$idCliente = $_GET["idCliente"];
$idDireccion = $_GET["idDireccion"];
$xml = new Xml();
$xml->startTag("Cliente");
datosCliente($xml,$idCliente,$idDireccion,$fecha);
$xml->closeTag("Cliente");
echo $xml->toString();
?>
