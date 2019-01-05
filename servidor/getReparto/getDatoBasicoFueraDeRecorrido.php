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

  $sql = "SELECT * FROM ClientesFueraDeRecorrido WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
  $tablaFR = $conexion->query($sql);

  if($tablaFR->num_rows>0)
      {
      $k=0;
      while($k<=$cliente)
        {
        $k++;
        $rowFR = $tablaFR->fetch_assoc();
        }
      $xml->addTag("IdCliente",$rowFR["IdCliente"]);
      $xml->addTag("IdDireccion",$rowFR["IdDireccion"]);
      }
  $conector->cerrarConexion();
  }

$xml->closeTag("DatoBasico");
echo $xml->toString();
?>
