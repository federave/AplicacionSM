<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');



$idRepartidor = $_POST["idRepartidor"];
$fecha = $_POST["fecha"];

$descarga = new SimpleXMLElement($_POST["descarga"]);


/////////////////////////////////////////////////////////////////////

$aux = true;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $bidones20L = $descarga->Bidones20L;
  $bidones12L = $descarga->Bidones12L;
  $bidones10L = $descarga->Bidones10L;
  $bidones8L = $descarga->Bidones8L;
  $bidones5L = $descarga->Bidones5L;
  $packBotellas2L = $descarga->PackBotellas2L;
  $packBotellas500mL = $descarga->PackBotellas500mL;
  $bidones20LVacios = $descarga->Vacios->Bidones20L;
  $bidones12LVacios = $descarga->Vacios->Bidones12L;

  $cero=0;

  $sql = "INSERT INTO Descargas (IdEmpleado,Fecha,NBidon20L,NBidon12L,NBidon10L,NBidon8L,NBidon5L,NPackBotellas2L,NPackBotellas500mL,NBidon20L_V,NBidon12L_V,NDispFC,NDispNat)VALUES('$idRepartidor','$fecha','$bidones20L','$bidones12L','$bidones10L','$bidones8L','$bidones5L','$packBotellas2L','$packBotellas500mL',$bidones20LVacios,$bidones12LVacios,'$cero','$cero')";
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
