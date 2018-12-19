<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');


$idRepartidor = $_POST["idRepartidor"];
$fecha = $_POST["fecha"];

$carga = new SimpleXMLElement($_POST["carga"]);




/////////////////////////////////////////////////////////////////////

$aux = true;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $bidones20L = $carga->Bidones20L;
  $bidones12L = $carga->Bidones12L;
  $bidones10L = $carga->Bidones10L;
  $bidones8L = $carga->Bidones8L;
  $bidones5L = $carga->Bidones5L;
  $packBotellas2L = $carga->PackBotellas2L;
  $packBotellas500mL = $carga->PackBotellas500mL;

  $cero=0;

  $sql = "INSERT INTO Cargas (IdEmpleado,Fecha,NBidon20L,NBidon12L,NBidon10L,NBidon8L,NBidon5L,NPackBotellas2L,NPackBotellas500mL,NDispFC,NDispNat)VALUES('$idRepartidor','$fecha','$bidones20L','$bidones12L','$bidones10L','$bidones8L','$bidones5L','$packBotellas2L','$packBotellas500mL','$cero','$cero')";
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
