<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');


$idRepartidor = $_POST["idRepartidor"];
$fecha = $_POST["fecha"];


$gasto = new SimpleXMLElement($_POST["gasto"]);


/////////////////////////////////////////////////////////////////////

$aux = true;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();


  $descripcion="";
  if(count($gasto->xpath("Combustible")) > 0 )
    {
    $combustible = $gasto->Combustible;
    $descripcion = $gasto->Descripcion;
    $otros=0;
    }
  else
    {
    $otros = $gasto->Otros;
    $descripcion = $gasto->Descripcion;
    $combustible=0;
    }
  $dinero = $gasto->Dinero;


  $sql = "INSERT INTO Gastos_Repartidor (IdEmpleado,Fecha,Combustible,Otros,Descripcion,DineroGastado)VALUES('$idRepartidor','$fecha','$combustible','$otros','$descripcion','$dinero')";
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
