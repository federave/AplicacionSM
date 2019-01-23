<?php




function datosActualidadCliente(&$xml,$idCliente,$idDireccion,$fecha)
{

$alquiler = datosActualidadAlquiler($xml,$idCliente,$fecha);
datosInactividad($xml,$idCliente,$idDireccion,$fecha,$alquiler);
datosActualidadBidonesDispenserFC($xml,$idCliente,$fecha);
preciosProductos($xml,$idCliente,$fecha);

}


function datosActualidadBidonesDispenserFC(&$xml,$idCliente,$fecha)
{
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $date = new DateTime($fecha);
  $fechaAux = $date->sub(new DateInterval('P30D'));
  $fechaAux = $fechaAux->format('Y-m-d H:i:s');


  $xml->startTag("ActualidadBidonesDispenserFC");
    $sql = "SELECT * FROM Bidones_Servicios_Cliente WHERE IdCliente = '$idCliente' AND Fecha>='$fechaAux' AND Fecha<='$fecha' ORDER BY Fecha DESC";
    $tablaBSC = $conexion->query($sql);
    if($tablaBSC->num_rows>0)
      {
      $rowBSC = $tablaBSC->fetch_assoc();
      $xml->addTag("DispenserFC",$rowBSC["NDispFC"]);
      $xml->addTag("Bidones20L",$rowBSC["NBidon20L"]);
      $xml->addTag("Bidones12L",$rowBSC["NBidon12L"]);
      }

  $xml->closeTag("ActualidadBidonesDispenserFC");
  $conector->cerrarConexion();
  }
}

function diferenciaDias($fecha1,$fecha2)
{
$date1 = new DateTime($fecha1);
$date2 = new DateTime($fecha2);
$diff = $date1->diff($date2);
return $diff->days;
}

function datosInactividad(&$xml,$idCliente,$idDireccion,$fecha,$alquiler)
{

// Estado Inactividad
$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $xml->startTag("Inactividad");

  $date = new DateTime($fecha);
  $fechaAux = $date->sub(new DateInterval('P30D'));
  $fechaAux = $fechaAux->format('Y-m-d H:i:s');

  $sql = "SELECT * FROM PlanillaDinamica WHERE IdCliente = '$idCliente' AND Fecha >= '$fechaAux' AND Fecha < '$fecha' AND Estado_ClienteAtendido = 1
  AND (NBidon20L>0 OR NBidon12L>0 OR NBidon20L_A>0 OR NBidon12L_A>0 OR NBidon10L>0 OR NBidon8L>0 OR NBidon5L>0 OR NPackBotellas2L>0 OR NPackBotellas500mL>0)
  ORDER BY Fecha DESC";

  $tablaPD = $conexion->query($sql);
  if($tablaPD->num_rows>0)
    {

    $rowPD = $tablaPD->fetch_assoc();
    $fechaConsumo = $rowPD["Fecha"];
    $datosConsumo =" ";
    if($rowPD["NBidon20L_A"] > 0)
      $datosConsumo.="*Bidones de 20L Alquiler: ".$rowPD["NBidon20L_A"];
    if($rowPD["NBidon12L_A"] > 0)
      $datosConsumo.="*Bidones de 12L Alquiler: ".$rowPD["NBidon12L_A"];
    if($rowPD["NBidon20L"] > 0)
      $datosConsumo.="*Bidones de 20L: ".$rowPD["NBidon20L"];
    if($rowPD["NBidon12L"] > 0)
        $datosConsumo.="*Bidones de 12L: ".$rowPD["NBidon12L"];
    if($rowPD["NBidon10L"] > 0)
      $datosConsumo.="*Bidones de 10L: ".$rowPD["NBidon10L"];
    if($rowPD["NBidon8L"] > 0)
      $datosConsumo.="*Bidones de 8L: ".$rowPD["NBidon8L"];
    if($rowPD["NBidon5L"] > 0)
      $datosConsumo.="*Bidones de 5L: ".$rowPD["NBidon5L"];
    if($rowPD["NPackBotellas2L"] > 0)
      $datosConsumo.="*Pack de Botellas de 2L: ".$rowPD["NPackBotellas2L"];
    if($rowPD["NPackBotellas500mL"] > 0)
      $datosConsumo.="*Pack de Botellas de 500mL: ".$rowPD["NPackBotellas500mL"];

    if($alquiler)
      {
      $xml->addTag("IdInactividad",1);
      }
    else
      {
      if(diferenciaDias($fecha,$fechaConsumo)<10){$xml->addTag("IdInactividad",2);}//hace 10 dias
      elseif (diferenciaDias($fecha,$fechaConsumo)<20){$xml->addTag("IdInactividad",3);}//hace mas de 10 dias y menos de 20 luz amarilla
      else{$xml->addTag("IdInactividad",4);}//hace mas de 20 dias luz roja
      }

    $fechaConsumoAux = new DateTime($fechaConsumo);
    $fechaConsumo = $fechaConsumoAux->format('Y-m-d');
    $xml->addTag("UltimoConsumo",$fechaConsumo.$datosConsumo);

    }
  else
    {
    $date = new DateTime($fecha);
    $fechaAux = $date->sub(new DateInterval('P20D'));
    $fechaAux = $fechaAux->format('Y-m-d H:i:s');

    $sql = "SELECT * FROM HistoriaCliente WHERE IdCliente = '$idCliente' AND Fecha >= '$fechaAux' AND Alta=1";
    $tablaHC = $conexion->query($sql);
    if($tablaHC->num_rows>0)
      {
      $xml->addTag("IdInactividad",5);  // Cliente Nuevo o que volvio a comprar pero se considera nuevo
      $xml->addTag("UltimoConsumo","");
      }
    else
      {
      if($alquiler)
        $xml->addTag("IdInactividad",1);
      else
        $xml->addTag("IdInactividad",4);

      $xml->addTag("UltimoConsumo","Hace mas de 40 dias que no compra");
      }


    }
    $conector->cerrarConexion();

  $xml->closeTag("Inactividad");
  }


}




function datosActualidadAlquiler(&$xml,$idCliente,$fecha)
{
if(tieneAlquiler($idCliente,$fecha))
  {
  $xml->startTag("ActualidadAlquiler");

  $conector = new Conector();

  if($conector->abrirConexion())
    {
    $conexion = $conector->getConexion();

    $date = strtotime($fecha);
    $year = date("Y", $date);
    $mes = date("m", $date);

    $sql = "SELECT * FROM Deudas_AlquilerDispenserFC WHERE IdCliente = '$idCliente' AND Año = '$year' AND Mes = '$mes'";

    $tablaDeudas_ADFC = $conexion->query($sql);

    if($tablaDeudas_ADFC->num_rows>0)
      {
      $rowDeudas_ADFC = $tablaDeudas_ADFC->fetch_assoc();
      $xml->addTag("Alquileres6BidonesPagados",$rowDeudas_ADFC["NAlq6B_P"]);
      $xml->addTag("Alquileres8BidonesPagados",$rowDeudas_ADFC["NAlq8B_P"]);
      $xml->addTag("Alquileres10BidonesPagados",$rowDeudas_ADFC["NAlq10B_P"]);
      $xml->addTag("Alquileres12BidonesPagados",$rowDeudas_ADFC["NAlq12B_P"]);
      }

    $sql = "SELECT * FROM AlquilerDispenser_BidonesEntregados WHERE IdCliente = '$idCliente' AND Año = '$year' AND Mes = '$mes'";

    $tablaADBE = $conexion->query($sql);

    if($tablaADBE->num_rows>0)
      {
      $rowADBE = $tablaADBE->fetch_assoc();
      $xml->addTag("Bidones20LEntregados",$rowADBE["NBidon20L"]);
      $xml->addTag("Bidones12LEntregados",$rowADBE["NBidon12L"]);
      }
    $conector->cerrarConexion();
    }
    $xml->closeTag("ActualidadAlquiler");
    return true;
  }
  else
  {
    return false;
  }
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





?>
