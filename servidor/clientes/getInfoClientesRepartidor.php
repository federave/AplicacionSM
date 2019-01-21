<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');


$idRepartidor = $_GET["idRepartidor"];


$xml = new Xml();
$xml->startTag("InfoClientesRepartidor");

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $sql = "SELECT IdCliente FROM Clientes WHERE IdEmpleado = '$idRepartidor' AND Activo = 1";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
      {
      $xml->addTag("NumeroClientes",$tabla->num_rows);
      }
  else
      {
      $xml->addTag("NumeroClientes",0);
      }
  }
$xml->closeTag("InfoClientesRepartidor");

echo $xml->toString();
?>
