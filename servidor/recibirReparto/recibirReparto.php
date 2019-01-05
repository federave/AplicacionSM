<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');
include_once('../../modelo/precios/precios.php');
include_once('precioProductos.php');
include_once('alquileres.php');
include_once('bidonesCliente.php');
include_once('deudaProductos.php');
include_once('observaciones.php');


$idRepartidor = $_POST["idRepartidor"];
$fecha = $_POST["fecha"];


$reparto = new SimpleXMLElement($_POST["reparto"]);

$idCliente = $reparto->IdCliente;
$idDireccion = $reparto->IdDireccion;


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


  $sql = "SELECT * FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND IdCliente = '$idCliente'  AND IdDireccion = '$idDireccion' AND  Fecha = '$fecha'";
  $tabla = $conexion->query($sql);

  if($tabla->num_rows>0)
    {
    $sql = "UPDATE PlanillaDinamica SET Estado_ClienteAtendido='$visitado',NBidon20L='$bidones20L',NBidon12L='$bidones12L',NBidon10L='$bidones10L',NBidon8L='$bidones8L',NBidon5L='$bidones5L',NPackBotellas2L='$packBotellas2L',NPackBotellas500mL='$packBotellas500mL',NBidon20L_B='$bidones20LBonificados',NBidon12L_B='$bidones12LBonificados',NBidon10L_B='$bidones10LBonificados',NBidon8L_B='$bidones8LBonificados',NBidon5L_B='$bidones5LBonificados',NPackBotellas2L_B='$packBotellas2LBonificados',NPackBotellas500mL_B='$packBotellas500mLBonificados',NBidon20L_A='$bidones20LAlquiler',NBidon12L_A='$bidones12LAlquiler',NBidon20L_V='$bidones20LVacios',NBidon12L_V='$bidones12LVacios',DineroProductos='$dinero' WHERE IdEmpleado = '$idRepartidor' AND IdCliente = '$idCliente'  AND IdDireccion = '$idDireccion' AND  Fecha = '$fecha'";
    $aux &= $conexion->query($sql);
    }
  else
    {
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
