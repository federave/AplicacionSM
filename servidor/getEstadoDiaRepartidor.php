<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');


$idRepartidor = $_GET["idRepartidor"];
$fecha = $_GET["fecha"];


$xml = new Xml();
$xml->startTag("DiaRepartidor");

$conector = new Conector();


if($conector->abrirConexion())
  {

  $conexion = $conector->getConexion();
  $sql = "SELECT * FROM DiaRepartidor WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
  $tabla = $conexion->query($sql);

  if($tabla->num_rows>0)
      {
      $row = $tabla->fetch_assoc();
      $xml->addTag("DiaCreado",boolToString($row["Estado_Planilla_Creada"]));
      $xml->addTag("DiaCompletado",boolToString($row["Estado_Planilla_Completada"]));
      }
  else
      {
      $xml->addTag("DiaCreado",false);
      $xml->addTag("DiaCompletado",false);
      }

  }
else
  {
  $xml->addTag("DiaCreado",false);
  $xml->addTag("DiaCompletado",false);
  }

$xml->closeTag("DiaRepartidor");

echo $xml->toString();
?>
