<?php

function eliminarDispensadores($idCliente,$idDireccion,$idRepartidor,$fecha)
{
$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $aux=true;

  $sql = "SET SQL_SAFE_UPDATES = 0";
  $aux &= $conexion->query($sql);

  $sql = "DELETE FROM VentaVertedores WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Idrepartidor = '$idRepartidor' AND Fecha = '$fecha'";
  $aux &= $conexion->query($sql);
  $sql = "DELETE FROM EntregaVertedores WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Idrepartidor = '$idRepartidor' AND Fecha = '$fecha'";
  $aux &= $conexion->query($sql);
  $sql = "DELETE FROM CambioVertedores WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Idrepartidor = '$idRepartidor' AND Fecha = '$fecha'";
  $aux &= $conexion->query($sql);
  $sql = "DELETE FROM VentaDispensers WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Idrepartidor = '$idRepartidor' AND Fecha = '$fecha'";
  $aux &= $conexion->query($sql);
  $sql = "DELETE FROM EntregaDispensers WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Idrepartidor = '$idRepartidor' AND Fecha = '$fecha'";
  $aux &= $conexion->query($sql);
  $sql = "DELETE FROM CambioDispensers WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Idrepartidor = '$idRepartidor' AND Fecha = '$fecha'";
  $aux &= $conexion->query($sql);
  $sql = "DELETE FROM RetiroDispensers WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND Idrepartidor = '$idRepartidor' AND Fecha = '$fecha'";
  $aux &= $conexion->query($sql);

  $sql = "SET SQL_SAFE_UPDATES = 1";
  $aux &= $conexion->query($sql);

  $conector->cerrarConexion();
  }

return $aux;
}






function actualizarDispensadores($reparto,$idCliente,$idDireccion,$idRepartidor,$fecha)
{
$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $aux=true;

  if(count($reparto->xpath("VentaDispensers"))> 0)
    {
    $cantidad=$reparto->VentaDispensers->Cantidad;
    $especial=$reparto->VentaDispensers->Especial;
    $precioespecial=$reparto->VentaDispensers->PrecioEspecial;
    $sql = "INSERT INTO VentaDispensers (idcliente,iddireccion,idrepartidor,fecha,cantidad,especial,precioespecial)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$cantidad','$especial','$precioespecial')";
    $aux &= $conexion->query($sql);
    }

  if(count($reparto->xpath("EntregaDispensers"))> 0)
    {
    $cantidad = $reparto->EntregaDispensers->Cantidad;
    $sql = "INSERT INTO EntregaDispensers (idcliente,iddireccion,idrepartidor,fecha,cantidad)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$cantidad')";
    $aux &= $conexion->query($sql);
    }

  if(count($reparto->xpath("CambioDispensers"))> 0)
    {
    $cantidad = $reparto->CambioDispensers->Cantidad;
    $sql = "INSERT INTO CambioDispensers (idcliente,iddireccion,idrepartidor,fecha,cantidad)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$cantidad')";
    $aux &= $conexion->query($sql);
    }

  if(count($reparto->xpath("RetiroDispensers"))> 0)
    {
    $cantidad = $reparto->RetiroDispensers->Cantidad;
    $sql = "INSERT INTO RetiroDispensers (idcliente,iddireccion,idrepartidor,fecha,cantidad)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$cantidad')";
    $aux &= $conexion->query($sql);
    }


  if(count($reparto->xpath("VentaVertedores"))> 0)
    {

    $cantidad=$reparto->VentaVertedores->Cantidad;
    $especial=$reparto->VentaVertedores->Especial;
    $precioespecial=$reparto->VentaVertedores->PrecioEspecial;


    $sql = "INSERT INTO VentaVertedores(idcliente,iddireccion,idrepartidor,fecha,cantidad,especial,precioespecial)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$cantidad','$especial','$precioespecial')";
    $aux &= $conexion->query($sql);
    }

  if(count($reparto->xpath("EntregaVertedores"))> 0)
    {
    $cantidad = $reparto->EntregaVertedores->Cantidad;
    $sql = "INSERT INTO EntregaVertedores (idcliente,iddireccion,idrepartidor,fecha,cantidad)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$cantidad')";
    $aux &= $conexion->query($sql);
    }

  if(count($reparto->xpath("CambioVertedores"))> 0)
    {
    $cantidad = $reparto->CambioVertedores->Cantidad;
    $sql = "INSERT INTO CambioVertedores (idcliente,iddireccion,idrepartidor,fecha,cantidad)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$cantidad')";
    $aux &= $conexion->query($sql);
    }

  $conector->cerrarConexion();
  }

return $aux;
}














 ?>
