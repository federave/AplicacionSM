<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');
include_once('../../modelo/precios/precios.php');
include_once('precioProductos.php');
include_once('datosActualidadCliente.php');
$fecha = $_GET["fecha"];
$idCliente = $_GET["idCliente"];
$idDireccion = $_GET["idDireccion"];
$xml = new Xml();
$xml->startTag("ActualidadCliente");
datosActualidadCliente($xml,$idCliente,$idDireccion,$fecha);
$xml->closeTag("ActualidadCliente");
echo $xml->toString();
?>
