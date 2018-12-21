<?php





function getPrecioAlquileresCliente($idCliente,$fecha)
{

$precioAlquileres = new PrecioAlquileres($fecha);

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $sql = "SELECT * FROM AcuerdosDispenser WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";
  $tablaAD = $conexion->query($sql);

  if($tablaAD->num_rows>0)
      {
      $rowAD = $tablaAD->fetch_assoc();

      if(($rowAD["PrecioEspecial"] == 1) && ($rowAD["PAlq6B"]!=-1 || $rowAD["PAlq8B"]!=-1 || $rowAD["PAlq10B"]!=-1 ||$rowAD["PAlq12B"]!=-1))
          {

          if($rowAD["PAlq6B"]!=-1)
            {
            $precioAlquileres->setAlquiler6Bidones($rowAD["PAlq6B"]);
            }
          if($rowAD["PAlq8B"]!=-1)
            {
            $precioAlquileres->setAlquiler8Bidones($rowAD["PAlq8B"]);
            }
          if($rowAD["PAlq10B"]!=-1)
            {
            $precioAlquileres->setAlquiler10Bidones($rowAD["PAlq10B"]);
            }
          if($rowAD["PAlq12B"]!=-1)
            {
            $precioAlquileres->setAlquiler12Bidones($rowAD["PAlq12B"]);
            }

          }

      }


  $conector->cerrarConexion();
  }

return $precioAlquileres;
}



function tieneAlquiler($idCliente,$fecha)
{

$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $date = strtotime($fecha);
  $year = date("Y", $date);
  $mes = date("m", $date);

  $sql = "SELECT * FROM AlquilerDispenser_BidonesEntregados WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
  $tablaAD = $conexion->query($sql);
  if($tablaAD->num_rows>0)
      {
      $aux=true;
      }
  $conector->cerrarConexion();
  }

return $aux;
}


function eliminarDatosAlquiler($idCliente,$idDireccion,$idRepartidor,$fecha)
{

if(tieneAlquiler($idCliente,$fecha))
  {

  $aux=false;
  $conector = new Conector();

  if($conector->abrirConexion())
    {
    $conexion = $conector->getConexion();

    ////// ENTREGA DE BIDONES

    $aux1=false;

    // Busqueda en Planilla Dinamica

    $sql = "SELECT * FROM PlanillaDinamica WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
    $tablaPD = $conexion->query($sql);
    if($tablaPD->num_rows>0)
        {
        $rowPD = $tablaPD->fetch_assoc();

        $bidones20LAlquilerPlanilla = $rowPD["NBidon20L_A"];
        $bidones12LAlquilerPlanilla = $rowPD["NBidon12L_A"];

        // Busqueda en AlquilerDispenser BidonesEntregados

        $date = strtotime($fecha);
        $year = date("Y", $date);
        $mes = date("m", $date);

        $sql = "SELECT * FROM AlquilerDispenser_BidonesEntregados WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
        $tablaAD = $conexion->query($sql);
        if($tablaAD->num_rows>0)
            {
            $rowAD = $tablaAD->fetch_assoc();

            $bidones20LAlquilerEntregados = $rowAD["NBidon20L"];
            $bidones12LAlquilerEntregados = $rowAD["NBidon12L"];

            $bidones20LAlquilerEntregadosOld = $bidones20LAlquilerEntregados - $bidones20LAlquilerPlanilla;
            $bidones12LAlquilerEntregadosOld = $bidones12LAlquilerEntregados - $bidones12LAlquilerPlanilla;

            // Actualizacion a Old AlquilerDispenser BidonesEntregados

            $sql = "UPDATE AlquilerDispenser_BidonesEntregados SET NBidon20L='$bidones20LAlquilerEntregadosOld',NBidon12L='$bidones12LAlquilerEntregadosOld' WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
            $aux1 = $conexion->query($sql);





            }

        }

    ////// PAGO DE ALQUILERES

    $aux2 = true;

    // Busqueda de Pagos , puede no haber


    $sql = "SELECT * FROM Pagos_Repartidor_Alquileres WHERE IdCliente = '$idCliente' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
    $tablaPA = $conexion->query($sql);
    if($tablaPA->num_rows>0)
        {
        $rowPA = $tablaPA->fetch_assoc();

        $alquileres6BidonesPagados = $rowPA["NAlq6B"];
        $alquileres8BidonesPagados = $rowPA["NAlq8B"];
        $alquileres10BidonesPagados = $rowPA["NAlq10B"];
        $alquileres12BidonesPagados = $rowPA["NAlq12B"];
        $dineroPagado = $rowPA["DineroTotal"];

        // Busqueda de Estado Actual Deuda Alquileres

        $sql = "SELECT * FROM Deudas_AlquilerDispenserFC WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
        $tablaDA = $conexion->query($sql);
        if($tablaDA->num_rows>0)
            {
            $rowDA = $tablaDA->fetch_assoc();

            $alquileres6BidonesPagadosActual = $rowDA["NAlq6B_P"];
            $alquileres8BidonesPagadosActual = $rowDA["NAlq8B_P"];
            $alquileres10BidonesPagadosActual = $rowDA["NAlq10B_P"];
            $alquileres12BidonesPagadosActual = $rowDA["NAlq12B_P"];
            $dineroDeuda = $rowDA["DineroTotal"];

            $alquileres6BidonesPagadosOld = $alquileres6BidonesPagadosActual - $alquileres6BidonesPagados;
            $alquileres8BidonesPagadosOld = $alquileres8BidonesPagadosActual - $alquileres8BidonesPagados;
            $alquileres10BidonesPagadosOld = $alquileres10BidonesPagadosActual - $alquileres10BidonesPagados;
            $alquileres12BidonesPagadosOld = $alquileres12BidonesPagadosActual - $alquileres12BidonesPagados;

            $dineroDeudaOld = $dineroDeuda + $dineroPagado;

            $estadoDeuda = 1;
            if($dineroDeudaOld==0){$estadoDeuda = 0;}



            // Actualizacion a Old  Deuda Alquileres

            $sql = "UPDATE Deudas_AlquilerDispenserFC SET NAlq6B_P='$alquileres6BidonesPagadosOld',NAlq8B_P='$alquileres8BidonesPagadosOld',NAlq10B_P='$alquileres10BidonesPagadosOld',NAlq12B_P='$alquileres12BidonesPagadosOld',DineroTotal='$dineroDeudaOld',Estado_Deuda='$estadoDeuda' WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
            $aux2 &= $conexion->query($sql);

            $sql = "SET SQL_SAFE_UPDATES = 0";
            $aux2 &= $conexion->query($sql);

            $sql = "DELETE FROM Pagos_Repartidor_Alquileres WHERE IdCliente = '$idCliente' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
            $aux2 &= $conexion->query($sql);

            $sql = "SET SQL_SAFE_UPDATES = 1";
            $aux2 &= $conexion->query($sql);


            }

        }

    $aux = $aux1 & $aux2;


    $conector->cerrarConexion();
    }
  return $aux;
  }
else
  {
  return true;
  }

}


function actualizarEntregaBidonesAlquiler($bidones20L,$bidones12L,$idCliente,$fecha)
{

$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();


  $date = strtotime($fecha);
  $year = date("Y", $date);
  $mes = date("m", $date);

  $sql = "SELECT * FROM AlquilerDispenser_BidonesEntregados WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
  $tablaAD = $conexion->query($sql);
  if($tablaAD->num_rows>0)
      {
      $rowAD = $tablaAD->fetch_assoc();

      $bidones20LAlquilerOld = $rowAD["NBidon20L"];
      $bidones12LAlquilerOld = $rowAD["NBidon12L"];

      $bidones20LAlquilerNew = $bidones20LAlquilerOld + $bidones20L;
      $bidones12LAlquilerNew = $bidones12LAlquilerOld + $bidones12L;

      // Actualizacion de AlquilerDispenser BidonesEntregados

      $sql = "UPDATE AlquilerDispenser_BidonesEntregados SET NBidon20L='$bidones20LAlquilerNew',NBidon12L='$bidones12LAlquilerNew' WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
      $aux = $conexion->query($sql);



    }

  $conector->cerrarConexion();
  }

return $aux;
}





function actualizarDeudaAlquiler($idCliente,$idRepartidor,$fecha)
{

$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $date = strtotime($fecha);
  $year = date("Y", $date);
  $mes = date("m", $date);

  $sql = "SELECT * FROM Pagos_Repartidor_Alquileres WHERE IdCliente = '$idCliente' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
  $tablaPA = $conexion->query($sql);


  if($tablaPA->num_rows>0)
      {
      $rowPA = $tablaPA->fetch_assoc();

      $alquileres6BidonesPagados = $rowPA["NAlq6B"];
      $alquileres8BidonesPagados = $rowPA["NAlq8B"];
      $alquileres10BidonesPagados = $rowPA["NAlq10B"];
      $alquileres12BidonesPagados = $rowPA["NAlq12B"];
      $dineroPagado = $rowPA["DineroTotal"];

      // Busqueda de Estado Actual Deuda Alquileres




      $sql = "SELECT * FROM Deudas_AlquilerDispenserFC WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
      $tablaDA = $conexion->query($sql);
      if($tablaDA->num_rows>0)
          {
          $rowDA = $tablaDA->fetch_assoc();




          $alquileres6BidonesPagadosOld = $rowDA["NAlq6B_P"];
          $alquileres8BidonesPagadosOld = $rowDA["NAlq8B_P"];
          $alquileres10BidonesPagadosOld = $rowDA["NAlq10B_P"];
          $alquileres12BidonesPagadosOld = $rowDA["NAlq12B_P"];
          $dineroDeuda = $rowDA["DineroTotal"];

          $alquileres6BidonesPagadosNew = $alquileres6BidonesPagadosOld + $alquileres6BidonesPagados;
          $alquileres8BidonesPagadosNew = $alquileres8BidonesPagadosOld + $alquileres8BidonesPagados;
          $alquileres10BidonesPagadosNew = $alquileres10BidonesPagadosOld + $alquileres10BidonesPagados;
          $alquileres12BidonesPagadosNew = $alquileres12BidonesPagadosOld + $alquileres12BidonesPagados;

          $dineroDeudaNew = $dineroDeuda - $dineroPagado;

          $estadoDeuda = 1;
          if($dineroDeudaNew==0){$estadoDeuda = 0;}



          // Actualizacion de  Deuda Alquileres

          $sql = "UPDATE Deudas_AlquilerDispenserFC SET NAlq6B_P='$alquileres6BidonesPagadosNew',NAlq8B_P='$alquileres8BidonesPagadosNew',NAlq10B_P='$alquileres10BidonesPagadosNew',NAlq12B_P='$alquileres12BidonesPagadosNew',DineroTotal='$dineroDeudaNew',Estado_Deuda = '$estadoDeuda' WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
          $aux = $conexion->query($sql);



          }

      }

  $conector->cerrarConexion();
  }

return $aux;
}


/////////////////////////////////////////////////////////////////////




















?>
