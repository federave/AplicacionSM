<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');


$idRepartidor = $_GET["idRepartidor"];
$fecha = $_GET["fecha"];


$xml = new Xml();
$xml->startTag("InfoClientesFueraDeRecorrido");

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $sql = "SELECT IdCliente FROM ClientesFueraDeRecorrido WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
      {
      $xml->addTag("NumeroClientesFueraDeRecorrido",$tabla->num_rows);
      //$xml->addTag("NumeroClientesPlanilla",3);
      }
  else
      {
      $xml->addTag("NumeroClientesFueraDeRecorrido",0);
      }
  }
$xml->closeTag("InfoClientesFueraDeRecorrido");

echo $xml->toString();
?>
