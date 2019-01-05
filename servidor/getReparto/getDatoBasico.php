<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');

$idRepartidor = $_GET["idRepartidor"];
$fecha = $_GET["fecha"];
$cliente = $_GET["cliente"];

$xml = new Xml();
$xml->startTag("DatoBasico");

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $sql = "SELECT * FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$fecha' AND Orden='$cliente'";
  $tablaPD = $conexion->query($sql);

  if($tablaPD->num_rows>0)
      {
      $rowPD = $tablaPD->fetch_assoc();
      $xml->addTag("IdCliente",$rowPD["IdCliente"]);
      $xml->addTag("IdDireccion",$rowPD["IdDireccion"]);
      }
  $conector->cerrarConexion();
  }

$xml->closeTag("DatoBasico");
echo $xml->toString();
?>
