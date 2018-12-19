<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');
include_once('../modelo/precios/precios.php');


$idRepartidor = $_POST["idRepartidor"];
$fecha = $_POST["fecha"];


$reparto = new SimpleXMLElement($_POST["reparto"]);

$idCliente = $reparto->IdCliente;
$idDireccion = $reparto->IdDireccion;



/////////////////////////////////////////////////////////////////////

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

            $sql = "UPDATE AlquilerDispenser_BidonesEntregados SET NBidon20L='$bidones20LAlquilerEntregadosOld',NBidon20L='$bidones12LAlquilerEntregadosOld' WHERE IdCliente = '$idCliente' AND Mes = '$mes' AND Año = '$year'";
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
      $bidones12LAlquilerOld= $rowAD["NBidon12L"];

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



function getPrecioProductosCliente($idCliente,$fecha)
{

$precioProductos = new PrecioProductos($fecha);

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();



  $sql = "SELECT * FROM Clientes WHERE IdCliente = '$idCliente'";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
      {
      $row = $tabla->fetch_assoc();

      $precioRetornables = new PrecioRetornables($fecha);
      $precioDescartables = new PrecioDescartables($fecha);




  if($row["Estado_AcuerdoDispenser"]==1 && $row["Estado_AcuerdoComercio"]==1)
    {
    $sql = "SELECT * FROM AcuerdosDispenser WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";
    $tablaAD = $conexion->query($sql);
    if($tablaAD->num_rows>0)
      {
      $rowAD = $tablaAD->fetch_assoc();
      $sql = "SELECT * FROM AcuerdosComercio WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";
      $tablaAC = $conexion->query($sql);
      if($tablaAC->num_rows>0)
        {
        $rowAC = $tablaAC->fetch_assoc();
        $idAcuerdoComercio = $rowAC["IdAcuerdoComercio"];
        $sql = "SELECT * FROM TiposAcuerdosComercio WHERE IdAcuerdoComercio = '$idAcuerdoComercio'";
        $tablaTAC = $conexion->query($sql);
        if($tablaTAC->num_rows>0)
          {
          $rowTAC = $tablaTAC->fetch_assoc();

          if($rowAD["PrecioEspecial"] == 1 && $rowTAC["PrecioEspecial"] == 1)
            {

            if($rowAD["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowAD["PBidon20L"]);}
            elseif($rowTAC["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowTAC["PBidon20L"]);}
            else{}

            if($rowAD["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowAD["PBidon12L"]);}
            elseif($rowTAC["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowTAC["PBidon12L"]);}
            else{}

            if($rowTAC["PBidon10L"]!=-1){$precioDescartables->setBidon10L($rowTAC["PBidon10L"]);}
            if($rowTAC["PBidon8L"]!=-1){$precioDescartables->setBidon8L($rowTAC["PBidon8L"]);}
            if($rowTAC["PBidon5L"]!=-1){$precioDescartables->setBidon5L($rowTAC["PBidon5L"]);}
            if($rowTAC["PPackBotellas2L"]!=-1){$precioDescartables->setPackBotellas2L($rowTAC["PPackBotellas2L"]);}
            if($rowTAC["PPackBotellas500mL"]!=-1){$precioDescartables->setPackBotellas500mL($rowTAC["PPackBotellas500mL"]);}


            }
            elseif($rowAD["PrecioEspecial"] == 1 && $rowTAC["PrecioEspecial"] == 0)
              {
              if ($rowAD["PBidon20L"]!=-1 || $rowAD["PBidon12L"]!=-1)
                {
                if($rowAD["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowAD["PBidon20L"]);}
                if($rowAD["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowAD["PBidon12L"]);}

                }
              }
            elseif($rowAD["PrecioEspecial"] == 0 && $rowTAC["PrecioEspecial"] == 1)
              {

            if($rowTAC["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowTAC["PBidon20L"]);}
            if($rowTAC["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowTAC["PBidon12L"]);}
            if($rowTAC["PBidon10L"]!=-1){$precioDescartables->setBidon10L($rowTAC["PBidon10L"]);}
            if($rowTAC["PBidon8L"]!=-1){$precioDescartables->setBidon8L($rowTAC["PBidon8L"]);}
            if($rowTAC["PBidon5L"]!=-1){$precioDescartables->setBidon5L($rowTAC["PBidon5L"]);}
            if($rowTAC["PPackBotellas2L"]!=-1){$precioDescartables->setPackBotellas2L($rowTAC["PPackBotellas2L"]);}
            if($rowTAC["PPackBotellas500mL"]!=-1){$precioDescartables->setPackBotellas500mL($rowTAC["PPackBotellas500mL"]);}


              }
            else{}
            }
          }
        }
    }
  elseif($row["Estado_AcuerdoDispenser"]==0 && $row["Estado_AcuerdoComercio"]==1)
    {
    $sql = "SELECT * FROM AcuerdosComercio WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";
    $tablaAC = $conexion->query($sql);
    if($tablaAC->num_rows>0)
      {
      $rowAC = $tablaAC->fetch_assoc();
      $idAcuerdoComercio = $rowAC["IdAcuerdoComercio"];
      $sql = "SELECT * FROM TiposAcuerdosComercio WHERE IdAcuerdoComercio = '$idAcuerdoComercio'";
      $tablaTAC = $conexion->query($sql);
      if($tablaTAC->num_rows>0)
        {
        $rowTAC = $tablaTAC->fetch_assoc();


        if($rowTAC["PrecioEspecial"] == 1)
          {
          if($rowTAC["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowTAC["PBidon20L"]);}
          if($rowTAC["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowTAC["PBidon12L"]);}
          if($rowTAC["PBidon10L"]!=-1){$precioDescartables->setBidon10L($rowTAC["PBidon10L"]);}
          if($rowTAC["PBidon8L"]!=-1){$precioDescartables->setBidon8L($rowTAC["PBidon8L"]);}
          if($rowTAC["PBidon5L"]!=-1){$precioDescartables->setBidon5L($rowTAC["PBidon5L"]);}
          if ($rowTAC["PPackBotellas2L"]!=-1){$precioDescartables->setPackBotellas2L($rowTAC["PPackBotellas2L"]);}
          if ($rowTAC["PPackBotellas500mL"]!=-1){$precioDescartables->setPackBotellas500mL($rowTAC["PPackBotellas500mL"]);}


          }
        }
      }
    }
  elseif($row["Estado_AcuerdoDispenser"]==1 && $row["Estado_AcuerdoComercio"]==0)
    {
    $sql = "SELECT * FROM AcuerdosDispenser WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";
    $tablaAD = $conexion->query($sql);
    if($tablaAD->num_rows>0)
      {
      $rowAD = $tablaAD->fetch_assoc();
      if($rowAD["PrecioEspecial"] == 1)
        {
        if ($rowAD["PBidon20L"]!=-1 || $rowAD["PBidon12L"]!=-1)
          {
          if($rowAD["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowAD["PBidon20L"]);}
          if($rowAD["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowAD["PBidon12L"]);}

          }
        }
      }
    }
  else
    {

    }


    $precioProductos->setPrecioRetornables($precioRetornables);
    $precioProductos->setPrecioDescartables($precioDescartables);
  }
  $conector->cerrarConexion();
  }


return $precioProductos;
}


/////////////////////////////////////////////////////////////////////

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




/////////////////////////////////////////////////////////////////////

$aux=true;

//debug("comienzo");

$aux&=eliminarDeudasProductos($idCliente,$idRepartidor,$fecha);

$aux&=eliminarDatosAlquiler($idCliente,$idDireccion,$idRepartidor,$fecha);

$aux&=eliminarDatosBidonesCliente($idCliente,$idDireccion,$idRepartidor,$fecha);

$aux&=eliminarObservaciones($idCliente,$idDireccion,$idRepartidor,$fecha);



$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  /////// UPDATE Planilla Dinamica


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
            ///Bidones 20L
            $bidones20LExcedenteVendidos+=$reparto->Alquiler->ExcedenteAlquiler->Excedente->Bidones20L;
            ///Bidones 12L
            $bidones12LExcedenteVendidos+=$reparto->Alquiler->ExcedenteAlquiler->Excedente->Bidones12L;

            $dinero += $reparto->Alquiler->ExcedenteAlquiler->Excedente->Dinero;
            }

            if(count($reparto->Alquiler->ExcedenteAlquiler->xpath("Deuda")) > 0)
              {
              ///Bidones 20L
              $bidones20LExcedenteDeudados+=$reparto->Alquiler->ExcedenteAlquiler->Deuda->Bidones20L;
              ///Bidones 12L
              $bidones12LExcedenteDeudados+=$reparto->Alquiler->ExcedenteAlquiler->Deuda->Bidones12L;
              }
        }

    }



    ///DEUDA PRODUCTOS


  if(count($reparto->xpath("DeudaProductos"))> 0)
    {

    ///Bidones 20L
    $bidones20LDeudados+=$reparto->DeudaProductos->Bidones20L;

    ///Bidones 12L
    $bidones12LDeudados+=$reparto->DeudaProductos->Bidones12L;

    ///Bidones 10L
    $bidones10LDeudados+=$reparto->DeudaProductos->Bidones10L;

    ///Bidones 8L
    $bidones8LDeudados+=$reparto->DeudaProductos->Bidones8L;

    ///Bidones 5L
    $bidones5LDeudados+=$reparto->DeudaProductos->Bidones5L;

    ///Pack Botellas 2L
    $packBotellas2LDeudados+=$reparto->DeudaProductos->PackBotellas2L;

    ///Pack Botellas 500mL
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


  /////// VISITA

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


  /////// ACTUALIZACION DE PLANILLA


  $bidones20L = $bidones20LVendidos + $bidones20LDeudados + $bidones20LExcedenteVendidos + $bidones20LExcedenteDeudados;
  $bidones12L = $bidones12LVendidos + $bidones12LDeudados + $bidones12LExcedenteVendidos + $bidones12LExcedenteDeudados;
  $bidones10L = $bidones10LVendidos + $bidones10LDeudados;
  $bidones8L = $bidones8LVendidos + $bidones8LDeudados;
  $bidones5L = $bidones5LVendidos + $bidones5LDeudados;
  $packBotellas2L = $packBotellas2LVendidos + $packBotellas2LDeudados;
  $packBotellas500mL = $packBotellas500mLVendidos + $packBotellas500mLDeudados;

  $sql = "UPDATE PlanillaDinamica SET Estado_ClienteAtendido='$visitado',NBidon20L='$bidones20L',NBidon12L='$bidones12L',NBidon10L='$bidones10L',NBidon8L='$bidones8L',NBidon5L='$bidones5L',NPackBotellas2L='$packBotellas2L',NPackBotellas500mL='$packBotellas500mL',NBidon20L_B='$bidones20LBonificados',NBidon12L_B='$bidones12LBonificados',NBidon10L_B='$bidones10LBonificados',NBidon8L_B='$bidones8LBonificados',NBidon5L_B='$bidones5LBonificados',NPackBotellas2L_B='$packBotellas2LBonificados',NPackBotellas500mL_B='$packBotellas500mLBonificados',NBidon20L_A='$bidones20LAlquiler',NBidon12L_A='$bidones12LAlquiler',NBidon20L_V='$bidones20LVacios',NBidon12L_V='$bidones12LVacios',DineroProductos='$dinero' WHERE IdEmpleado = '$idRepartidor' AND IdCliente = '$idCliente'  AND IdDireccion = '$idDireccion' AND  Fecha = '$fecha'";

  $aux &= $conexion->query($sql);




  /////// ACTUALIZACION DE BIDONES

  $aux &= actualizarBidonesCliente($idCliente,$idDireccion,$idRepartidor,$fecha);



  /////// ACTUALIZACION DE ALQUILER

  if(tieneAlquiler($idCliente,$fecha))
    {


    $aux &= actualizarEntregaBidonesAlquiler($bidones20LAlquiler,$bidones12LAlquiler,$idCliente,$fecha);


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



  /////// ACTUALIZACION DE DEUDAS

  $bidones20LDeudadosTotal = $bidones20LDeudados + $bidones20LExcedenteDeudados;
  $bidones12LDeudadosTotal = $bidones12LDeudados + $bidones12LExcedenteDeudados;


  if($bidones20LDeudadosTotal>0 || $bidones12LDeudadosTotal>0 || $bidones10LDeudados>0 || $bidones8LDeudados>0 || $bidones5LDeudados>0 || $packBotellas2LDeudados>0 || $packBotellas500mLDeudados>0)
    {


    $precioProductos = getPrecioProductosCliente($idCliente,$fecha);


    $precioBidon20L = $precioProductos->getPrecioRetornables()->getBidon20L();
    $precioBidon12L = $precioProductos->getPrecioRetornables()->getBidon12L();
    $precioBidon10L = $precioProductos->getPrecioDescartables()->getBidon10L();
    $precioBidon8L = $precioProductos->getPrecioDescartables()->getBidon8L();
    $precioBidon5L = $precioProductos->getPrecioDescartables()->getBidon5L();
    $precioPackBotellas2L = $precioProductos->getPrecioDescartables()->getPackBotellas2L();
    $precioPackBotellas500mL = $precioProductos->getPrecioDescartables()->getPackBotellas500mL();

    $dineroDeuda = $bidones20LDeudadosTotal * $precioBidon20L + $bidones12LDeudadosTotal * $precioBidon12L + $bidones10LDeudados * $precioBidon10L + $bidones8LDeudados * $precioBidon8L + $bidones5LDeudados * $precioBidon5L  + $packBotellas2LDeudados * $precioPackBotellas2L + $packBotellas500mLDeudados * $precioPackBotellas500mL;

    $cero=0;
    $uno=1;

    $sql = "INSERT INTO Deudas_Productos (IdCliente,IdEmpleado,Fecha,NBidon20L,NBidon12L,NBidon10L,NBidon8L,NBidon5L,NPackBotellas2L,NPackBotellas500mL,NBidon20L_P,NBidon12L_P,NBidon10L_P,NBidon8L_P,NBidon5L_P,NPackBotellas2L_P,NPackBotellas500mL_P,PBidon20L,PBidon12L,PBidon10L,PBidon8L,PBidon5L,PPackBotellas2L,PPackBotellas500mL,DineroTotal,Estado_Deuda)VALUES('$idCliente','$idRepartidor','$fecha','$bidones20LDeudadosTotal','$bidones12LDeudadosTotal','$bidones10LDeudados','$bidones8LDeudados','$bidones5LDeudados','$packBotellas2LDeudados','$packBotellas500mLDeudados','$cero','$cero','$cero','$cero','$cero','$cero','$cero','$precioBidon20L','$precioBidon12L','$precioBidon10L','$precioBidon8L','$precioBidon5L','$precioPackBotellas2L','$precioPackBotellas500mL','$dineroDeuda',$uno)";



    $aux &= $conexion->query($sql);

    }

  /* Observaciones */
  if(count($reparto->xpath("Observacion")) > 0 )
    {
    $observacion = $reparto->Observacion;
    $sql = "INSERT INTO ObservacionesPlanillaDinamica (IdCliente,IdDireccion,IdEmpleado,Fecha,Observacion)VALUES('$idCliente','$idDireccion','$idRepartidor','$fecha','$observacion')";
    $aux &= $conexion->query($sql);
    }



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
