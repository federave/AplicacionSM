<?php



function eliminarDatosBidonesCliente($idCliente,$idDireccion,$idRepartidor,$fecha)
{

//debug("EliminarDatosBidonesCliente");

$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  // Busqueda en Bidones_Servicios_Cliente

  $sql = "SELECT * FROM Bidones_Servicios_Cliente WHERE IdCliente = '$idCliente' ORDER BY Fecha DESC";
  $tablaBC = $conexion->query($sql);
  if($tablaBC->num_rows>0)
      {



      $rowBC = $tablaBC->fetch_assoc();

      $bidones20LActual = $rowBC["NBidon20L"];
      $bidones12LActual = $rowBC["NBidon12L"];
      $fechaUltimaActualizacion = $rowBC["Fecha"];



      // Busqueda en Planilla Dinamica

      $sql = "SELECT * FROM PlanillaDinamica WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
      $tablaPD = $conexion->query($sql);
      if($tablaPD->num_rows>0)
          {
          $rowPD = $tablaPD->fetch_assoc();


          $bidones20LEntregados = $rowPD["NBidon20L"]+$rowPD["NBidon20L_B"]+$rowPD["NBidon20L_A"]+$rowPD["NBidon20L_O"];
          $bidones20LRecogidos = $rowPD["NBidon20L_V"];

          $bidones12LEntregados = $rowPD["NBidon12L"]+$rowPD["NBidon12L_B"]+$rowPD["NBidon12L_A"]+$rowPD["NBidon12L_O"];
          $bidones12LRecogidos = $rowPD["NBidon12L_V"];

          $bidones20LOld = $bidones20LActual - $bidones20LEntregados + $bidones20LRecogidos;
          $bidones12LOld = $bidones12LActual - $bidones12LEntregados + $bidones12LRecogidos;

          $date = strtotime($fechaUltimaActualizacion);
          $yearU = date("Y", $date);
          $mesU = date("m", $date);
          $dayU = date("d", $date);

          $date = strtotime($fecha);
          $year = date("Y", $date);
          $mes = date("m", $date);
          $day = date("d", $date);


          if($yearU == $year &&  $mesU == $mes && $dayU==$day)
            {
            $sql = "UPDATE Bidones_Servicios_Cliente SET NBidon20L='$bidones20LOld',NBidon12L='$bidones12LOld' WHERE IdCliente = '$idCliente' AND Fecha='$fecha'";
            $aux = $conexion->query($sql);
            }
          else
            {
            $aux=true;
            }


          }

      }
  $conector->cerrarConexion();
  }

return $aux;
}



function actualizarBidonesCliente($idCliente,$idDireccion,$idRepartidor,$fecha)
{

$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  // Busqueda en Bidones_Servicios_Cliente

  $sql = "SELECT * FROM Bidones_Servicios_Cliente WHERE IdCliente = '$idCliente' ORDER BY Fecha DESC";
  $tablaBC = $conexion->query($sql);
  if($tablaBC->num_rows>0)
      {
      $rowBC = $tablaBC->fetch_assoc();

      $bidones20LOld = $rowBC["NBidon20L"];
      $bidones12LOld = $rowBC["NBidon12L"];


      $fechaUltimaActualizacion = $rowBC["Fecha"];

      $ndispfc = $rowBC["NDispFC"];
      $ndispnat = $rowBC["NDispNat"];
      $nhelchicas = $rowBC["NHelChicas"];
      $nhelmedianas = $rowBC["NHelMedianas"];
      $nexhibidores = $rowBC["NExhibidores"];

      // Busqueda en Planilla Dinamica

      $sql = "SELECT * FROM PlanillaDinamica WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
      $tablaPD = $conexion->query($sql);
      if($tablaPD->num_rows>0)
          {
          $rowPD = $tablaPD->fetch_assoc();

          $bidones20LEntregados = $rowPD["NBidon20L"]+$rowPD["NBidon20L_B"]+$rowPD["NBidon20L_A"]+$rowPD["NBidon20L_O"];
          $bidones20LRecogidos = $rowPD["NBidon20L_V"];

          $bidones12LEntregados = $rowPD["NBidon12L"]+$rowPD["NBidon12L_B"]+$rowPD["NBidon12L_A"]+$rowPD["NBidon12L_O"];
          $bidones12LRecogidos = $rowPD["NBidon12L_V"];

          $bidones20LActual = $bidones20LOld + $bidones20LEntregados - $bidones20LRecogidos;
          $bidones12LActual = $bidones12LOld + $bidones12LEntregados - $bidones12LRecogidos;

          // Actualizacion de  Bidones_Servicios_Cliente



          $date = strtotime($fechaUltimaActualizacion);
          $yearU = date("Y", $date);
          $mesU = date("m", $date);
          $dayU = date("d", $date);

          $date = strtotime($fecha);
          $year = date("Y", $date);
          $mes = date("m", $date);
          $day = date("d", $date);


          if($yearU == $year &&  $mesU == $mes && $dayU==$day)
            {
            $sql = "UPDATE Bidones_Servicios_Cliente SET NBidon20L='$bidones20LActual',NBidon12L='$bidones12LActual' WHERE IdCliente = '$idCliente' AND Fecha='$fecha'";
            }
          else
            {
            $sql = "INSERT INTO Bidones_Servicios_Cliente(IdCliente,NBidon20L,NBidon12L,NDispFC,NDispNat,NHelChicas,NHelMedianas,NExhibidores,Fecha)VALUES('$idCliente','$bidones20LActual','$bidones12LActual',
              '$ndispfc','$ndispnat','$nhelchicas','$nhelmedianas','$nexhibidores','$fecha')";
            }
          $aux = $conexion->query($sql);


          }

      }
  $conector->cerrarConexion();
  }

return $aux;
}








?>
