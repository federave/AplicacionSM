<?php

function eliminarObservaciones($idCliente,$idDireccion,$idRepartidor,$fecha)
{
$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $aux=true;

  $sql = "SET SQL_SAFE_UPDATES = 0";
  $aux &= $conexion->query($sql);

  $sql = "DELETE FROM ObservacionesPlanillaDinamica WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
  $aux &= $conexion->query($sql);

  $sql = "SET SQL_SAFE_UPDATES = 1";
  $aux &= $conexion->query($sql);

  $conector->cerrarConexion();
  }

return $aux;
}





 ?>
