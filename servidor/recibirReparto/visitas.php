<?php




function actualizarVisitas($reparto,$idCliente,$idDireccion,$idRepartidor,$fecha)
{
$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $aux=true;


    $idVisita = $reparto->TipoVisita->IdVisita;
    $visitado = 1;
    if($idVisita == 2 )
      $visitado=0;

    /////// ACTUALIZACION DE VISITAS

    $sql = "SELECT * FROM VisitasPlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND IdCliente = '$idCliente'  AND IdDireccion = '$idDireccion' AND  Fecha = '$fecha'";
    $tabla = $conexion->query($sql);
    if($tabla->num_rows>0)
        {
        $row = $tabla->fetch_assoc();
        $idAux = $row["Id"];
        $sql = "UPDATE VisitasPlanillaDinamica SET IdTipoVisita='$idVisita' WHERE Id='$idAux'";
        $aux &= $conexion->query($sql);
        }
    else
        {
        $sql = "INSERT INTO VisitasPlanillaDinamica (IdCliente,IdDireccion,IdEmpleado,Fecha,IdTipoVisita)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$idVisita')";
        $aux &= $conexion->query($sql);
        }

  $conector->cerrarConexion();
  }

return $aux;
}




?>
