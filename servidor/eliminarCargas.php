<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');


$idRepartidor = $_POST["idRepartidor"];
$fecha = $_POST["fecha"];



/////////////////////////////////////////////////////////////////////

$aux = true;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $sql = "DELETE FROM Cargas WHERE IdEmpleado='$idRepartidor' AND Fecha='$fecha'";
  $aux &= $conexion->query($sql);

  $sql = "UPDATE DiaRepartidor SET Numero_Cargas=0 WHERE IdEmpleado='$idRepartidor' AND Fecha='$fecha'";
  $aux &= $conexion->query($sql);

  $conector->cerrarConexion();
  }
else
  {
  $aux=false;
  }


$xml = new Xml();
$xml->addTag("EstadoDatoDiaRecibido",$aux);
echo $xml->toString();
?>
