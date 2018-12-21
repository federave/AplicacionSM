<?php



function eliminarDeudasProductos($idCliente,$idRepartidor,$fecha)
{
$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $sql = "DELETE FROM Deudas_Productos WHERE IdCliente = '$idCliente' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
  $aux = $conexion->query($sql);
  $conector->cerrarConexion();
  }
return $aux;
}













?>
