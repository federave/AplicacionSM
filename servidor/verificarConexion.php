<?php
include_once('../otros/otros.php');
$xml = new Xml();
$xml->startTag("Dato");
$xml->addTag("Estado","true");
$xml->closeTag("Dato");

/*
include_once('../modelo/conector.php');

$conector = new Conector();
$conector->abrirConexion();

$conexion = $conector->getConexion();
$sqlANT = "WWWWW";
$sql = "INSERT INTO Debug (debug)VALUES('$sqlANT')";
$sqlANT = "--"(string)$sql;

// $conexion->query($sql);

$sql = "INSERT INTO Debug (debug)VALUES('$sqlANT')";


$conexion->query($sql);
*/






echo $xml->toString();
?>
