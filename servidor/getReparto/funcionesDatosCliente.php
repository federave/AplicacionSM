<?php



//////////////////////////////////////////////////////////////////////////
///////////// BIDONES DISPENSER FC

function datosBidonesDispenserFC(&$xml,$idCliente,$fecha)
{
$conector = new Conector();
if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $date = new DateTime($fecha);
  $fechaAux = $date->sub(new DateInterval('P30D'));
  $fechaAux = $fechaAux->format('Y-m-d H:i:s');
  $sql = "SELECT NBidon20L,NBidon12L,NDispFC FROM Bidones_Servicios_Cliente WHERE IdCliente = '$idCliente' AND Fecha>='$fechaAux' AND Fecha<='$fecha' ORDER BY Fecha DESC";
  $tablaBSC = $conexion->query($sql);
  if($tablaBSC->num_rows>0)
    {
    $rowBSC = $tablaBSC->fetch_assoc();
    $xml->startTag("BidonesDispenserFC");
      $xml->addTag("DispenserFC",$rowBSC["NDispFC"]);
      $xml->addTag("Bidones20L",$rowBSC["NBidon20L"]);
      $xml->addTag("Bidones12L",$rowBSC["NBidon12L"]);
    $xml->closeTag("BidonesDispenserFC");
    }

  $conector->cerrarConexion();
  }
}


//////////////////////////////////////////////////////////////////////////
///////////// DATOS BASICOS

function datosBasicos(&$xml,$idCliente)
{
$conector = new Conector();
if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $sql = "SELECT * FROM Clientes WHERE IdCliente = '$idCliente'";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
    {
    $row = $tabla->fetch_assoc();
    $xml->startTag("Datos");
      $xml->addTag("IdCliente",$idCliente);
      $xml->addTag("Nombre",$row["Nombre"]);
      $xml->addTag("Apellido",$row["Apellido"]);
      $xml->addTag("Telefono",$row["Telefono1"]);
      $xml->addTag("IdTipoCliente",$row["IdTipoCliente"]);
    $xml->closeTag("Datos");
    }
  $conector->cerrarConexion();
  }
}


//////////////////////////////////////////////////////////////////////////
///////////// DIRECCION

function datosDireccion(&$xml,$idDireccion)
{
$conector = new Conector();
if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $xml->startTag("Direccion");
  $sql = "SELECT * FROM TipoDirecciones WHERE IdDireccion = '$idDireccion'";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
      {
      $row = $tabla->fetch_assoc();
      $xml->addTag("IdDireccion",$idDireccion);
      $xml->addTag("Calle",$row["Calle"]);
      $xml->addTag("Entre1",$row["Entre1"]);
      $xml->addTag("Entre2",$row["Entre2"]);
      $xml->addTag("Numero",$row["Numero"]);
      $xml->addTag("Departamento",$row["Departamento"]);
      $xml->addTag("Piso",$row["Piso"]);
      }
  $xml->closeTag("Direccion");
  $conector->cerrarConexion();
  }
}







//////////////////////////////////////////////////////////////////////////
///////////// ALQUILER

function datosAlquiler(&$xml,$idCliente,$fecha)
{
$alquiler = false;

$conector = new Conector();
if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $sql = "SELECT * FROM Clientes WHERE IdCliente = '$idCliente'";
  $tabla = $conexion->query($sql);
  if($tabla->num_rows>0)
    {
    $row = $tabla->fetch_assoc();
    if($row["Estado_AcuerdoDispenser"]==1)
      {

      $sql = "SELECT * FROM AcuerdosDispenser WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";

      $tablaAD = $conexion->query($sql);
      if($tablaAD->num_rows>0)
        {
        $rowAD = $tablaAD->fetch_assoc();

        if(($rowAD["NAlq6B"] + $rowAD["NAlq8B"] + $rowAD["NAlq10B"] + $rowAD["NAlq12B"] ) > 0)
          {

          $alquiler = true;

          $xml->startTag("Alquiler");
            $xml->addTag("Alquileres6Bidones",$rowAD["NAlq6B"]);
            $xml->addTag("Alquileres8Bidones",$rowAD["NAlq8B"]);
            $xml->addTag("Alquileres10Bidones",$rowAD["NAlq10B"]);
            $xml->addTag("Alquileres12Bidones",$rowAD["NAlq12B"]);

          if(($rowAD["PrecioEspecial"] == 1) && ($rowAD["PAlq6B"]!=-1 || $rowAD["PAlq8B"]!=-1 || $rowAD["PAlq10B"]!=-1 ||$rowAD["PAlq12B"]!=-1))
            {
            $precioAlquileres = new PrecioAlquileres($fecha);
            $xml->startTag("PrecioEspecialAlquiler");
              if($rowAD["PAlq6B"]!=-1){$precioAlquileres->setAlquiler6Bidones($rowAD["PAlq6B"]);}
              if($rowAD["PAlq8B"]!=-1){$precioAlquileres->setAlquiler8Bidones($rowAD["PAlq8B"]);}
              if($rowAD["PAlq10B"]!=-1){$precioAlquileres->setAlquiler10Bidones($rowAD["PAlq10B"]);}
              if($rowAD["PAlq12B"]!=-1){$precioAlquileres->setAlquiler12Bidones($rowAD["PAlq12B"]);}
              $xml->addTag("Alquiler6Bidones_PrecioEspecial",$precioAlquileres->getAlquiler6Bidones());
              $xml->addTag("Alquiler8Bidones_PrecioEspecial",$precioAlquileres->getAlquiler8Bidones());
              $xml->addTag("Alquiler10Bidones_PrecioEspecial",$precioAlquileres->getAlquiler10Bidones());
              $xml->addTag("Alquiler12Bidones_PrecioEspecial",$precioAlquileres->getAlquiler12Bidones());
            $xml->closeTag("PrecioEspecialAlquiler");
            }

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

          $xml->closeTag("Alquiler");
          }
        }
      }
    }
  $conector->cerrarConexion();
  }
return $alquiler;
}




//////////////////////////////////////////////////////////////////////////
///////////// INACTIVIDAD





function diferenciaDias($fecha1,$fecha2)
{
$date1 = new DateTime($fecha1);
$date2 = new DateTime($fecha2);
$diff = $date1->diff($date2);
return $diff->days;
}




function inactividad(&$xml,$idCliente,$idDireccion,$fecha,$alquiler)
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
/*
  escribir("Comienzo Inactividad");
  escribir($fechaAux);
  escribir("Fin Inactividad");
*/
  $sql = "SELECT NBidon20L_A,NBidon12L_A,NBidon20L,NBidon12L,NBidon10L,NBidon8L,NBidon5L,NPackBotellas2L,NPackBotellas500mL FROM PlanillaDinamica WHERE IdCliente = '$idCliente' AND Fecha >= '$fechaAux' AND Fecha < '$fecha' AND Estado_ClienteAtendido = 1
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
      $xml->addTag("IdInactividad",4);
      $xml->addTag("UltimoConsumo","Hace mas de 40 dias que no compra");
      }


    }

  $xml->closeTag("Inactividad");
  $conector->cerrarConexion();
  }


}



?>
