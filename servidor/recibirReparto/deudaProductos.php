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



/////// ACTUALIZACION DE DEUDAS

function actualizarDeudaProductos($reparto,$idCliente,$idRepartidor,$fecha)
{
$aux=false;
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $aux=true;

  $bidones20LDeudados=0;
  $bidones12LDeudados=0;
  $bidones10LDeudados=0;
  $bidones8LDeudados=0;
  $bidones5LDeudados=0;
  $packBotellas2LDeudados=0;
  $packBotellas500mLDeudados=0;

  $bidones20LExcedenteDeudados=0;
  $bidones12LExcedenteDeudados=0;


  if(count($reparto->xpath("Alquiler"))> 0)
    {
    if(count($reparto->Alquiler->xpath("ExcedenteAlquiler")) > 0)
      {
      if(count($reparto->Alquiler->ExcedenteAlquiler->xpath("Deuda")) > 0)
        {
        $bidones20LExcedenteDeudados+=$reparto->Alquiler->ExcedenteAlquiler->Deuda->Bidones20L;
        $bidones12LExcedenteDeudados+=$reparto->Alquiler->ExcedenteAlquiler->Deuda->Bidones12L;
        }
      }
    }

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

  $conector->cerrarConexion();
  }

return $aux;
}










?>
