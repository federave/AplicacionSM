<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');

$idEmpleado  = $_GET["idRepartidor"];
$idCliente  = $_GET["idCliente"];
$idDireccion  = $_GET["idDireccion"];
$fecha  = $_GET["fecha"];


$xml = new Xml();
$xml->startTag("Consulta");

$conector = new Conector();


if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $sql = "SELECT Activo FROM Clientes WHERE IdCliente = '$idCliente' ";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
      {
      $row = $tabla->fetch_assoc();
      if($row["Activo"]==1){

      $sql = "SELECT IdCliente FROM Direcciones WHERE IdDireccion = '$idDireccion'";
      $tabla = $conexion->query($sql);
      if($tabla->num_rows>0)
          {
          $row = $tabla->fetch_assoc();
          if($row["IdCliente"] == $idCliente)
            {
            $sql = "SELECT IdCliente FROM ClientesFueraDeRecorrido WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Fecha = '$fecha' AND IdEmpleado = '$idEmpleado'";
            $tabla = $conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $xml->addTag("EstadoAgregar","0");
                $xml->addTag("Mensaje","El cliente ya se encuentra agregado como fuera de recorrido");
                }
            else
                {
                $sql = "SELECT IdCliente FROM PLanillaDinamica WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Fecha = '$fecha' AND IdEmpleado = '$idEmpleado'";
                $tabla = $conexion->query($sql);
                if($tabla->num_rows>0)
                    {
                    $xml->addTag("EstadoAgregar","0");
                    $xml->addTag("Mensaje","El cliente ya se encuentra en la planilla del dia");
                    }
                else
                    {
                    $xml->addTag("EstadoAgregar","1");
                    $xml->addTag("Mensaje","Correcto");
                    }
                }
            }
          else
            {
            $xml->addTag("EstadoAgregar","0");
            $xml->addTag("Mensaje","El IdDireccion no corresponde al cliente");
            }
          }
        }
    else
      {
      $xml->addTag("EstadoAgregar","0");
      $xml->addTag("Mensaje","El Cliente no se encuentra activo");
      }
    }
  }
$xml->closeTag("Consulta");
echo $xml->toString();
?>
