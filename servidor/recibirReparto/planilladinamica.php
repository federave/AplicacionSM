<?php




function actualizarPlanillaDinamica($reparto,$idCliente,$idDireccion,$idRepartidor,$fecha)
{
$aux=false;
$conector = new Conector();
//escribir("PlanillaDinamica");
if($conector->abrirConexion())
  {
    //escribir("PlanillaDinamica 1");

  $conexion = $conector->getConexion();
  $aux=true;


  $dinero=0;

  ///Bidones 20L

  $bidones20LVendidos=0;
  $bidones20LBonificados=0;
  $bidones20LDeudados=0;
  $bidones20LExcedenteVendidos=0;
  $bidones20LExcedenteDeudados=0;
  $bidones20LAlquiler=0;
  $bidones20LVacios=0;

  ///Bidones 12L

  $bidones12LVendidos=0;
  $bidones12LBonificados=0;
  $bidones12LDeudados=0;
  $bidones12LExcedenteVendidos=0;
  $bidones12LExcedenteDeudados=0;
  $bidones12LAlquiler=0;
  $bidones12LVacios=0;

  ///Bidones 10L

  $bidones10LVendidos=0;
  $bidones10LBonificados=0;
  $bidones10LDeudados=0;

  ///Bidones 8L

  $bidones8LVendidos=0;
  $bidones8LBonificados=0;
  $bidones8LDeudados=0;

  ///Bidones 5L

  $bidones5LVendidos=0;
  $bidones5LBonificados=0;
  $bidones5LDeudados=0;

  ///Pack Botellas 2L

  $packBotellas2LVendidos=0;
  $packBotellas2LBonificados=0;
  $packBotellas2LDeudados=0;

  ///Pack Botellas 500mL

  $packBotellas500mLVendidos=0;
  $packBotellas500mLBonificados=0;
  $packBotellas500mLDeudados=0;


  /// VACIOS

  if(count($reparto->xpath("Vacios"))> 0)
    {
    $bidones20LVacios+=$reparto->Vacios->Bidones20L;
    $bidones12LVacios+=$reparto->Vacios->Bidones12L;
    }



  /// ALQUILER

  if(count($reparto->xpath("Alquiler"))> 0)
    {
    ///ENTREGA
    $bidones20LAlquiler+=$reparto->Alquiler->Bidones20L;
    $bidones12LAlquiler+=$reparto->Alquiler->Bidones12L;
    ///EXCEDENTE ALQUILER
    if(count($reparto->Alquiler->xpath("ExcedenteAlquiler")) > 0)
      {
      if(count($reparto->Alquiler->ExcedenteAlquiler->xpath("Excedente")) > 0)
        {
        $bidones20LExcedenteVendidos+=$reparto->Alquiler->ExcedenteAlquiler->Excedente->Bidones20L;
        $bidones12LExcedenteVendidos+=$reparto->Alquiler->ExcedenteAlquiler->Excedente->Bidones12L;
        $dinero += $reparto->Alquiler->ExcedenteAlquiler->Excedente->Dinero;
        }
      if(count($reparto->Alquiler->ExcedenteAlquiler->xpath("Deuda")) > 0)
        {
        $bidones20LExcedenteDeudados+=$reparto->Alquiler->ExcedenteAlquiler->Deuda->Bidones20L;
        $bidones12LExcedenteDeudados+=$reparto->Alquiler->ExcedenteAlquiler->Deuda->Bidones12L;
        }
      }
    }

  ///DEUDA PRODUCTOS

  if(count($reparto->xpath("DeudaProductos"))> 0)
    {
    $bidones20LDeudados+=$reparto->DeudaProductos->Bidones20L;
    $bidones12LDeudados+=$reparto->DeudaProductos->Bidones12L;
    $bidones10LDeudados+=$reparto->DeudaProductos->Bidones10L;
    $bidones8LDeudados+=$reparto->DeudaProductos->Bidones8L;
    $bidones5LDeudados+=$reparto->DeudaProductos->Bidones5L;
    $packBotellas2LDeudados+=$reparto->DeudaProductos->PackBotellas2L;
    $packBotellas500mLDeudados+=$reparto->DeudaProductos->PackBotellas500mL;
    }




  ///VENTA PRODUCTOS

  if(count($reparto->xpath("VentaProductos")) > 0)
    {

    $dinero += $reparto->VentaProductos->Dinero;

    $bidones20LVendidos+=$reparto->VentaProductos->Bidones20L;
    $bidones12LVendidos+=$reparto->VentaProductos->Bidones12L;
    $bidones10LVendidos+=$reparto->VentaProductos->Bidones10L;
    $bidones8LVendidos+=$reparto->VentaProductos->Bidones8L;
    $bidones5LVendidos+=$reparto->VentaProductos->Bidones5L;
    $packBotellas2LVendidos+=$reparto->VentaProductos->PackBotellas2L;
    $packBotellas500mLVendidos+=$reparto->VentaProductos->PackBotellas500mL;

    if(count($reparto->VentaProductos->xpath("Bonificados")) > 0)
      {
      $bidones20LBonificados+=$reparto->VentaProductos->Bonificados->Bidones20L;
      $bidones12LBonificados+=$reparto->VentaProductos->Bonificados->Bidones12L;
      $bidones10LBonificados+=$reparto->VentaProductos->Bonificados->Bidones10L;
      $bidones8LBonificados+=$reparto->VentaProductos->Bonificados->Bidones8L;
      $bidones5LBonificados+=$reparto->VentaProductos->Bonificados->Bidones5L;
      $packBotellas2LBonificados+=$reparto->VentaProductos->Bonificados->PackBotellas2L;
      $packBotellas500mLBonificados+=$reparto->VentaProductos->Bonificados->PackBotellas500mL;
      }

    }

    /////// ACTUALIZACION DE PLANILLA

    $bidones20L = $bidones20LVendidos + $bidones20LDeudados + $bidones20LExcedenteVendidos + $bidones20LExcedenteDeudados;
    $bidones12L = $bidones12LVendidos + $bidones12LDeudados + $bidones12LExcedenteVendidos + $bidones12LExcedenteDeudados;
    $bidones10L = $bidones10LVendidos + $bidones10LDeudados;
    $bidones8L = $bidones8LVendidos + $bidones8LDeudados;
    $bidones5L = $bidones5LVendidos + $bidones5LDeudados;
    $packBotellas2L = $packBotellas2LVendidos + $packBotellas2LDeudados;
    $packBotellas500mL = $packBotellas500mLVendidos + $packBotellas500mLDeudados;

    $tiempo_inicio = microtime(true);

    $sql = "SELECT NBidon20L,NBidon20L_B,NBidon20L_A,NBidon20L_V,NBidon12L,NBidon12L_B,NBidon12L_A,NBidon12L_V FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND IdCliente = '$idCliente'  AND IdDireccion = '$idDireccion' AND  Fecha = '$fecha'";
    $tabla = $conexion->query($sql);

    if($tabla->num_rows>0)
      {
      $row = $tabla->fetch_assoc();

      $bidones20LOld = $row["NBidon20L"]+$row["NBidon20L_B"]+$row["NBidon20L_A"];
      $bidones12LOld = $row["NBidon12L"]+$row["NBidon12L_B"]+$row["NBidon12L_A"];
      $bidones20LVaciosOld = $row["NBidon20L_V"];
      $bidones12LVaciosOld = $row["NBidon12L_V"];
      $bidones20LAlquilerOld = $row["NBidon20L_A"];
      $bidones12LAlquilerOld = $row["NBidon12L_A"];

      $visitado=1;

      $sql = "UPDATE PlanillaDinamica SET Estado_ClienteAtendido='$visitado',NBidon20L='$bidones20L',NBidon12L='$bidones12L',NBidon10L='$bidones10L',NBidon8L='$bidones8L',NBidon5L='$bidones5L',NPackBotellas2L='$packBotellas2L',NPackBotellas500mL='$packBotellas500mL',NBidon20L_B='$bidones20LBonificados',NBidon12L_B='$bidones12LBonificados',NBidon10L_B='$bidones10LBonificados',NBidon8L_B='$bidones8LBonificados',NBidon5L_B='$bidones5LBonificados',NPackBotellas2L_B='$packBotellas2LBonificados',NPackBotellas500mL_B='$packBotellas500mLBonificados',NBidon20L_A='$bidones20LAlquiler',NBidon12L_A='$bidones12LAlquiler',NBidon20L_V='$bidones20LVacios',NBidon12L_V='$bidones12LVacios',DineroProductos='$dinero' WHERE IdEmpleado = '$idRepartidor' AND IdCliente = '$idCliente'  AND IdDireccion = '$idDireccion' AND  Fecha = '$fecha'";
      $aux &= $conexion->query($sql);
      }
    else
      {

      $bidones20LOld = 0;
      $bidones12LOld = 0;
      $bidones20LVaciosOld = 0;
      $bidones12LVaciosOld = 0;
      $bidones20LAlquilerOld = 0;
      $bidones12LAlquilerOld = 0;

      $sql = "INSERT INTO ClientesFueraDeRecorrido (IdCliente,IdDireccion,IdEmpleado,Fecha,IdFueraDeRecorrido,Mensaje)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','1','')";
      $aux = $conexion->query($sql);

      $sql = "SELECT COUNT(IdCliente) FROM PlanillaDinamica WHERE Fecha='$fecha' AND IdEmpleado='$idRepartidor'";
      $tabla = $conexion->query($sql);
      $row = $tabla->fetch_assoc();

      $orden = $row["COUNT(IdCliente)"];

      $sql = "SELECT IdEmpleado FROM Clientes WHERE IdCliente='$idCliente'";
      $tabla = $conexion->query($sql);

      $row = $tabla->fetch_assoc();
      $idEmpleadoVendedor = $row["IdEmpleado"];

      if($idEmpleadoVendedor==$idEmpleado)
        $idEmpleadoVendedor=-1;

      $sql = "INSERT INTO PlanillaDinamica (IdCliente,IdDireccion,IdEmpleado,IdEmpleado_Vendedor,Fecha,Orden,Estado_ClienteAtendido,NBidon20L,NBidon12L,NBidon10L,NBidon8L,NBidon5L,NPackBotellas2L,NPackBotellas500mL,NBidon20L_B,NBidon12L_B,NBidon10L_B,NBidon8L_B,NBidon5L_B,NPackBotellas2L_B,NPackBotellas500mL_B,NBidon20L_V,NBidon12L_V,NBidon20L_O,NBidon12L_O,NBidon10L_O,NBidon8L_O,NBidon5L_O,NPackBotellas2L_O,NPackBotellas500mL_O,NBidon20L_A,NBidon12L_A,DineroProductos,Estado_CPF,Estado_CPD_Auxiliar,Estado_CExtra,Estado_CVendeor)VALUES('$idCliente','$idDireccion','$idRepartidor','$idEmpleadoVendedor','$fecha','$orden',1,'$bidones20L','$bidones12L','$bidones10L','$bidones8L','$bidones5L','$packBotellas2L','$packBotellas500mL','$bidones20LBonificados','$bidones12LBonificados','$bidones10LBonificados','$bidones8LBonificados','$bidones5LBonificados','$packBotellas2LBonificados','$packBotellas500mLBonificados','$bidones20LVacios','$bidones12LVacios',0,0,0,0,0,0,0,'$bidones20LAlquiler','$bidones12LAlquiler','$dinero',0,0,1,0)";
      $aux = $conexion->query($sql);

      }

      $tiempo_fin = microtime(true);
      escribir("Planilla: " . ($tiempo_fin - $tiempo_inicio));

    //En este punto tenemos ya actualizada la planilla y tenemos los datos viejos que ella tenia

    // Actualizaciones de Bidones Cliente
    // 1) Leer datos viejos
    // 2) Hacer Calculos
    // 3) Actualizar

    //escribir("A");
    $tiempo_inicio = microtime(true);

    $sql = "SELECT * FROM Bidones_Servicios_Cliente WHERE IdCliente = '$idCliente' ORDER BY Fecha DESC";
    $tabla = $conexion->query($sql);
    if($tabla->num_rows>0)
      {

      //escribir("B");

      $row = $tabla->fetch_assoc();
      $fechaUltimaActualizacion = $row["Fecha"];

      $ndispfc = $row["NDispFC"];
      $ndispnat = $row["NDispNat"];
      $nhelchicas = $row["NHelChicas"];
      $nhelmedianas = $row["NHelMedianas"];
      $nexhibidores = $row["NExhibidores"];

      //Calculo de Nuevos Valores

      $dif20LVieja = $bidones20LOld - $bidones20LVaciosOld;
      $bidones20L = $bidones20L + $bidones20LAlquiler; // $bidones20L NO TENIA LOS DE ALQUILER
      $dif20LNueva = $bidones20L - $bidones20LVacios;
      $bidones20LNuevo = $row["NBidon20L"] - $dif20LVieja + $dif20LNueva;

      /*escribir("Diferencia Vieja: " . $dif20LVieja);
      escribir("Diferencia Nueva: " . $dif20LNueva);
      escribir("Valor Viejo: " . $row["NBidon20L"]);
      escribir("Valor Nuevo: " . $bidones20LNuevo);
*/


      $dif12LVieja = $bidones12LOld - $bidones12LVaciosOld;
      $bidones12L = $bidones12L + $bidones12LAlquiler; // $bidones12L NO TENIA LOS DE ALQUILER
      $dif12LNueva = $bidones12L - $bidones12LVacios;
      $bidones12LNuevo = $row["NBidon12L"] - $dif12LVieja + $dif12LNueva;

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
        $sql = "UPDATE Bidones_Servicios_Cliente SET NBidon20L='$bidones20LNuevo',NBidon12L='$bidones12LNuevo' WHERE IdCliente = '$idCliente' AND Fecha='$fecha'";
        $aux &= $conexion->query($sql);
        }
      else
        {
        $sql = "INSERT INTO Bidones_Servicios_Cliente(IdCliente,NBidon20L,NBidon12L,NDispFC,NDispNat,NHelChicas,NHelMedianas,NExhibidores,Fecha)VALUES('$idCliente','$bidones20LNuevo','$bidones12LNuevo',
        '$ndispfc','$ndispnat','$nhelchicas','$nhelmedianas','$nexhibidores','$fecha')";
        $aux &= $conexion->query($sql);
        }

      }

      $tiempo_fin = microtime(true);
      escribir("Bidones: " . ($tiempo_fin - $tiempo_inicio));

      // Actualizaciones de Alquileres
      // 1) Leer datos viejos
      // 2) Hacer Calculos
      // 3) Actualizar
      $tiempo_inicio = microtime(true);

      if(tieneAlquiler($idCliente,$fecha))
        {



        $date = strtotime($fecha);
        $year = date("Y", $date);
        $mes = date("m", $date);

        $sql = "SELECT * FROM AlquilerDispenser_BidonesEntregados WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
        $tablaAD = $conexion->query($sql);
        if($tablaAD->num_rows>0)
          {
          $rowAD = $tablaAD->fetch_assoc();

          $bidones20LAlquilerEntregadosOld = $rowAD["NBidon20L"];
          $bidones12LAlquilerEntregadosOld = $rowAD["NBidon12L"];

          $bidones20LAlquilerNew = $bidones20LAlquilerEntregadosOld - $bidones20LAlquilerOld + $bidones20LAlquiler;
          $bidones12LAlquilerNew = $bidones12LAlquilerOld - $bidones12LAlquilerOld + $bidones12LAlquiler;

          // Actualizacion de AlquilerDispenser BidonesEntregados

          $sql = "UPDATE AlquilerDispenser_BidonesEntregados SET NBidon20L='$bidones20LAlquilerNew',NBidon12L='$bidones12LAlquilerNew' WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
          $aux = $conexion->query($sql);

          }





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



        /// ALQUILER
        if(count($reparto->xpath("Alquiler")) > 0 )
          {
          ///PAGO
          $alquiler6Bidones=0;
          $alquiler8Bidones=0;
          $alquiler10Bidones=0;
          $alquiler12Bidones=0;

          if(count($reparto->Alquiler->xpath("PagoAlquiler")) > 0)
            {
            $alquiler6Bidones+=$reparto->Alquiler->PagoAlquiler->Alquiler6Bidones;
            $alquiler8Bidones+=$reparto->Alquiler->PagoAlquiler->Alquiler8Bidones;
            $alquiler10Bidones+=$reparto->Alquiler->PagoAlquiler->Alquiler10Bidones;
            $alquiler12Bidones+=$reparto->Alquiler->PagoAlquiler->Alquiler12Bidones;
            }

          if($alquiler6Bidones>0 || $alquiler8Bidones>0 || $alquiler10Bidones>0 || $alquiler12Bidones>0 )
            {
            $precioAlquileres = getPrecioAlquileresCliente($idCliente,$fecha);
            $dineroPago = $alquiler6Bidones * $precioAlquileres->getAlquiler6Bidones() + $alquiler8Bidones * $precioAlquileres->getAlquiler8Bidones() + $alquiler10Bidones * $precioAlquileres->getAlquiler10Bidones() + $alquiler12Bidones * $precioAlquileres->getAlquiler12Bidones();
            $date = strtotime($fecha);
            $year = date("Y", $date);
            $mes = date("m", $date);
            $sql = "INSERT INTO Pagos_Repartidor_Alquileres (IdCliente,IdEmpleado,Fecha,Mes,Año,NAlq6B,NAlq8B,NAlq10B,NAlq12B,DineroTotal)VALUES('$idCliente','$idRepartidor','$fecha','$mes','$year','$alquiler6Bidones','$alquiler8Bidones','$alquiler10Bidones','$alquiler12Bidones','$dineroPago')";
            $aux &= $conexion->query($sql);
            $aux &= actualizarDeudaAlquiler($idCliente,$idRepartidor,$fecha);
            }
          }
        }

        $tiempo_fin = microtime(true);
        escribir("Alquiler: " . ($tiempo_fin - $tiempo_inicio));







  $conector->cerrarConexion();
  }

return $aux;
}




?>
