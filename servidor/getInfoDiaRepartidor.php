<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');


$idRepartidor = $_GET["idRepartidor"];
$fecha = $_GET["fecha"];


$xml = new Xml();
$xml->startTag("InfoDiaRepartidor");

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $sql = "SELECT IdCliente FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
      {
      $xml->addTag("NumeroClientesPlanilla",$tabla->num_rows);
      //$xml->addTag("NumeroClientesPlanilla",3);
      }
  else
      {
      $xml->addTag("NumeroClientesPlanilla",0);
      }
  }
$xml->closeTag("InfoDiaRepartidor");

echo $xml->toString();
?>
