<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');

$idRepartidor = $_GET["idRepartidor"];
$idCliente = $_GET["idCliente"]; // El ultimo idCliene guardado



$xml = new Xml();
$xml->startTag("DatosBasicosCliente");

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  if($idCliente == 0)
    {
    $sql = "SELECT IdCliente FROM Clientes WHERE Activo=1 AND IdEmpleado='$idRepartidor' ORDER BY IdCliente ASC ";
    $tabla = $conexion->query($sql);
    $row = $tabla->fetch_assoc();
    $idCliente = $row["IdCliente"];
    }
  else
    {
    $sql = "SELECT IdCliente FROM Clientes WHERE IdCliente > '$idCliente' AND Activo=1 AND IdEmpleado='$idRepartidor' ORDER BY IdCliente ASC";
    $tabla = $conexion->query($sql);
    $row = $tabla->fetch_assoc();
    $idCliente = $row["IdCliente"];
    }

    $sql = "SELECT C.IdCliente,D.IdDireccion FROM Clientes as C INNER JOIN Direcciones as D ON C.IdCliente=D.IdCliente WHERE C.IdCliente='$idCliente'";
    $tabla = $conexion->query($sql);


    if($tabla->num_rows>0)
        {
        while($row = $tabla->fetch_assoc())
            {
            $xml->startTag("DatoBasico");
              $xml->addTag("IdCliente",$row["IdCliente"]);
              $xml->addTag("IdDireccion",$row["IdDireccion"]);
            $xml->closeTag("DatoBasico");
            }
        }

  $conector->cerrarConexion();
  }

$xml->closeTag("DatosBasicosCliente");
echo $xml->toString();
?>
