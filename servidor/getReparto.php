<?php
include_once('../otros/otros.php');
include_once('../modelo/conector.php');
include_once('../modelo/precios/precios.php');


function diferenciaDias($fecha1,$fecha2)
{

  $date1 = new DateTime($fecha1);
  $date2 = new DateTime($fecha2);
  $diff = $date1->diff($date2);
  return $diff->days;
}

function datosCliente(&$xml,$idCliente,$idDireccion,$fecha)
{



$xml->startTag("DatosCliente");

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


      // Datos de Alquiler

      $alquiler = false;

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
                  $xml->startTag("PrecioEspecialAlquiler");

                  $precioAlquileres = new PrecioAlquileres($fecha);

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


        if($row["Estado_OrdenDeCompra"] == 1){}


        // Bidones Dispenser FC

        $xml->startTag("BidonesDispenserFC");

        $sql = "SELECT * FROM Bidones_Servicios_Cliente WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";
        $tablaBSC = $conexion->query($sql);
        if($tablaBSC->num_rows>0)
          {
          $rowBSC = $tablaBSC->fetch_assoc();
          $xml->addTag("DispenserFC",$rowBSC["NDispFC"]);
          $xml->addTag("Bidones20L",$rowBSC["NBidon20L"]);
          $xml->addTag("Bidones12L",$rowBSC["NBidon12L"]);
          }
        $xml->closeTag("BidonesDispenserFC");


        // Estado Inactividad

        $xml->startTag("Inactividad");

        if($alquiler == false)
          {
          $sql = "SELECT * FROM PlanillaDinamica WHERE IdCliente = '$idCliente' AND Fecha < '$fecha' AND Estado_ClienteAtendido = 1 ORDER BY Fecha DESC";
          $tablaPD = $conexion->query($sql);
          if($tablaPD->num_rows>0)
              {
              $k=0;
              $rowPD = $tablaPD->fetch_assoc();
              $k++;
              $fechaConsumo = $rowPD["Fecha"];
              $datosConsumo = "";
              if($rowPD["NBidon20L"] > 0 || $rowPD["NBidon12L"] > 0 || $rowPD["NBidon10L"] > 0 || $rowPD["NBidon8L"] > 0 || $rowPD["NBidon5L"] > 0 || $rowPD["NPackBotellas2L"] > 0 || $rowPD["NPackBotellas500mL"] > 0
               || $rowPD["NBidon20L_A"] > 0 || $rowPD["NBidon12L_A"] > 0 )
                {
                $consumo=true;
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
                }
              else
                {$consumo=false;}

              while($consumo == false && $k < $tablaPD->num_rows)
                  {
                  $rowPD = $tablaPD->fetch_assoc();
                  $k++;
                  $fechaConsumo = $rowPD["Fecha"];

                  if($rowPD["NBidon20L"] > 0 || $rowPD["NBidon12L"] > 0 || $rowPD["NBidon10L"] > 0 || $rowPD["NBidon8L"] > 0 || $rowPD["NBidon5L"] > 0 || $rowPD["NPackBotellas2L"] > 0 || $rowPD["NPackBotellas500mL"] > 0
                   || $rowPD["NBidon20L_A"] > 0 || $rowPD["NBidon12L_A"] > 0 )
                    {
                    $consumo=true;
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
                    }
                  else
                    {$consumo=false;}

                  }

                if(diferenciaDias($fecha,$fechaConsumo)<10){$xml->addTag("IdInactividad",2);}//hace 10 dias
                elseif (diferenciaDias($fecha,$fechaConsumo)<20){$xml->addTag("IdInactividad",3);}//hace mas de 10 dias y menos de 20 luz amarilla
                else{$xml->addTag("IdInactividad",4);}//hace mas de 20 dias luz roja

                $date = strtotime($fechaConsumo);
                $year = date("Y", $date);
                $mes = date("m", $date);
                $dia = date("d", $date);
                $fechaConsumo = $year."-".$mes."-".$dia."*";

                if($consumo)
                  $xml->addTag("UltimoConsumo",$fechaConsumo.$datosConsumo);
                else
                  $xml->addTag("UltimoConsumo","No hay datos registrados de consumo");

                }
              else
                {
                $xml->addTag("IdInactividad",5);//cliente nuevo
                }
            }
          else
            {

            $sql = "SELECT * FROM PlanillaDinamica WHERE IdCliente = '$idCliente' AND Fecha < '$fecha' AND Estado_ClienteAtendido = 1 ORDER BY Fecha DESC";
            $tablaPD = $conexion->query($sql);
            if($tablaPD->num_rows>0)
                {
                $k=0;
                $rowPD = $tablaPD->fetch_assoc();
                $k++;
                $fechaConsumo = $rowPD["Fecha"];
                $datosConsumo = "";
                if($rowPD["NBidon20L"] > 0 || $rowPD["NBidon12L"] > 0 || $rowPD["NBidon10L"] > 0 || $rowPD["NBidon8L"] > 0 || $rowPD["NBidon5L"] > 0 || $rowPD["NPackBotellas2L"] > 0 || $rowPD["NPackBotellas500mL"] > 0
                 || $rowPD["NBidon20L_A"] > 0 || $rowPD["NBidon12L_A"] > 0 )
                  {
                  $consumo=true;
                  if($rowPD["NBidon20L_A"] > 0)
                    $datosConsumo.="*Bidones de 20L Alquiler: ".$rowPD["NBidon20L_A"];
                  if($rowPD["NBidon12L_A"] > 0)
                    $datosConsumo.="*Bidones de 12L Alquiler: ".$rowPD["NBidon12L_A"];
                  if($rowPD["NBidon20L"] > 0)
                    $datosConsumo.="*Bidones de 20L Excedente: ".$rowPD["NBidon20L"];
                  if($rowPD["NBidon12L"] > 0)
                      $datosConsumo.="*Bidones de 12L Excedente: ".$rowPD["NBidon12L"];
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
                  }
                else
                  {$consumo=false;}

                while($consumo == false && $k < $tablaPD->num_rows)
                    {
                    $rowPD = $tablaPD->fetch_assoc();
                    $k++;
                    $fechaConsumo = $rowPD["Fecha"];

                    if($rowPD["NBidon20L"] > 0 || $rowPD["NBidon12L"] > 0 || $rowPD["NBidon10L"] > 0 || $rowPD["NBidon8L"] > 0 || $rowPD["NBidon5L"] > 0 || $rowPD["NPackBotellas2L"] > 0 || $rowPD["NPackBotellas500mL"] > 0
                     || $rowPD["NBidon20L_A"] > 0 || $rowPD["NBidon12L_A"] > 0 )
                      {
                      $consumo=true;
                      if($rowPD["NBidon20L_A"] > 0)
                        $datosConsumo.="*Bidones de 20L Alquiler: ".$rowPD["NBidon20L_A"];
                      if($rowPD["NBidon12L_A"] > 0)
                        $datosConsumo.="*Bidones de 12L Alquiler: ".$rowPD["NBidon12L_A"];
                      if($rowPD["NBidon20L"] > 0)
                        $datosConsumo.="*Bidones de 20L Excedente: ".$rowPD["NBidon20L"];
                      if($rowPD["NBidon12L"] > 0)
                          $datosConsumo.="*Bidones de 12L Excedente: ".$rowPD["NBidon12L"];
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
                      }
                    else
                      {$consumo=false;}

                    }

                  $date = strtotime($fechaConsumo);
                  $year = date("Y", $date);
                  $mes = date("m", $date);
                  $dia = date("d", $date);
                  $fechaConsumo = $year."-".$mes."-".$dia."*";

                  $xml->addTag("IdInactividad",1);//con alquiler

                  if($consumo)
                    $xml->addTag("UltimoConsumo",$fechaConsumo.$datosConsumo);
                  else
                    $xml->addTag("UltimoConsumo","No hay datos registrados de consumo");

            }
            else
              {
              $xml->addTag("IdInactividad",5);//cliente nuevo
              }

          }

          $xml->closeTag("Inactividad");
      }
  }
$xml->closeTag("DatosCliente");
}



function preciosProductos(&$xml,$idCliente,$fecha)
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

                $xml->startTag("PrecioEspecialProductos");
                  $xml->addTag("Bidon20L_PrecioEspecial",$precioRetornables->getBidon20L());
                  $xml->addTag("Bidon12L_PrecioEspecial",$precioRetornables->getBidon12L());
                  $xml->addTag("Bidon10L_PrecioEspecial",$precioDescartables->getBidon10L());
                  $xml->addTag("Bidon8L_PrecioEspecial",$precioDescartables->getBidon8L());
                  $xml->addTag("Bidon5L_PrecioEspecial",$precioDescartables->getBidon5L());
                  $xml->addTag("PackBotellas2L_PrecioEspecial",$precioDescartables->getPackBotellas2L());
                  $xml->addTag("PackBotellas500mL_PrecioEspecial",$precioDescartables->getPackBotellas500mL());
                $xml->closeTag("PrecioEspecialProductos");

                }
                elseif($rowAD["PrecioEspecial"] == 1 && $rowTAC["PrecioEspecial"] == 0)
                  {
                  if ($rowAD["PBidon20L"]!=-1 || $rowAD["PBidon12L"]!=-1)
                    {
                    if($rowAD["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowAD["PBidon20L"]);}
                    if($rowAD["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowAD["PBidon12L"]);}
                    $xml->startTag("PrecioEspecialProductos");
                      $xml->addTag("Bidon20L_PrecioEspecial",$precioRetornables->getBidon20L());
                      $xml->addTag("Bidon12L_PrecioEspecial",$precioRetornables->getBidon12L());
                      $xml->addTag("Bidon10L_PrecioEspecial",$precioDescartables->getBidon10L());
                      $xml->addTag("Bidon8L_PrecioEspecial",$precioDescartables->getBidon8L());
                      $xml->addTag("Bidon5L_PrecioEspecial",$precioDescartables->getBidon5L());
                      $xml->addTag("PackBotellas2L_PrecioEspecial",$precioDescartables->getPackBotellas2L());
                      $xml->addTag("PackBotellas500mL_PrecioEspecial",$precioDescartables->getPackBotellas500mL());
                    $xml->closeTag("PrecioEspecialProductos");
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

                $xml->startTag("PrecioEspecialProductos");
                  $xml->addTag("Bidon20L_PrecioEspecial",$precioRetornables->getBidon20L());
                  $xml->addTag("Bidon12L_PrecioEspecial",$precioRetornables->getBidon12L());
                  $xml->addTag("Bidon10L_PrecioEspecial",$precioDescartables->getBidon10L());
                  $xml->addTag("Bidon8L_PrecioEspecial",$precioDescartables->getBidon8L());
                  $xml->addTag("Bidon5L_PrecioEspecial",$precioDescartables->getBidon5L());
                  $xml->addTag("PackBotellas2L_PrecioEspecial",$precioDescartables->getPackBotellas2L());
                  $xml->addTag("PackBotellas500mL_PrecioEspecial",$precioDescartables->getPackBotellas500mL());
                $xml->closeTag("PrecioEspecialProductos");

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

              $xml->startTag("PrecioEspecialProductos");
                $xml->addTag("Bidon20L_PrecioEspecial",$precioRetornables->getBidon20L());
                $xml->addTag("Bidon12L_PrecioEspecial",$precioRetornables->getBidon12L());
                $xml->addTag("Bidon10L_PrecioEspecial",$precioDescartables->getBidon10L());
                $xml->addTag("Bidon8L_PrecioEspecial",$precioDescartables->getBidon8L());
                $xml->addTag("Bidon5L_PrecioEspecial",$precioDescartables->getBidon5L());
                $xml->addTag("PackBotellas2L_PrecioEspecial",$precioDescartables->getPackBotellas2L());
                $xml->addTag("PackBotellas500mL_PrecioEspecial",$precioDescartables->getPackBotellas500mL());
              $xml->closeTag("PrecioEspecialProductos");
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
              $xml->startTag("PrecioEspecialProductos");
                $xml->addTag("Bidon20L_PrecioEspecial",$precioRetornables->getBidon20L());
                $xml->addTag("Bidon12L_PrecioEspecial",$precioRetornables->getBidon12L());
                $xml->addTag("Bidon10L_PrecioEspecial",$precioDescartables->getBidon10L());
                $xml->addTag("Bidon8L_PrecioEspecial",$precioDescartables->getBidon8L());
                $xml->addTag("Bidon5L_PrecioEspecial",$precioDescartables->getBidon5L());
                $xml->addTag("PackBotellas2L_PrecioEspecial",$precioDescartables->getPackBotellas2L());
                $xml->addTag("PackBotellas500mL_PrecioEspecial",$precioDescartables->getPackBotellas500mL());
              $xml->closeTag("PrecioEspecialProductos");
              }
            }
          }
        }
      else
        {

        }
      }
  }
}


///////// lo que se ejecuta


$idRepartidor = $_GET["idRepartidor"];
$fecha = $_GET["fecha"];
$cliente = $_GET["cliente"];

$xml = new Xml();
$xml->startTag("Reparto");

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $sql = "SELECT * FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
  $tablaPD = $conexion->query($sql);

  if($tablaPD->num_rows>0)
      {

      $k=0;
      while($k<=$cliente)
        {
        $k++;
        $rowPD = $tablaPD->fetch_assoc();
        }

      $idCliente = $rowPD["IdCliente"];
      $idDireccion = $rowPD["IdDireccion"];

      if($rowPD["IdEmpleado_Vendedor"]!=-1)
        {
        $xml->startTag("Vendedor");
            $xml->addTag("IdVendedor",$rowPD["IdEmpleado_Vendedor"]);
        $xml->closeTag("Vendedor");
        }

      datosCliente($xml,$idCliente,$idDireccion,$fecha);

      if($rowPD["NBidon20L"] > 0 || $rowPD["NBidon12L"] > 0 || $rowPD["NBidon10L"] > 0 || $rowPD["NBidon8L"] > 0 || $rowPD["NBidon5L"] > 0 || $rowPD["NPackBotellas2L"] > 0 || $rowPD["NPackBotellas500mL"] > 0 )
        {
        $xml->startTag("VentaProductos");
          $xml->addTag("Bidones20L_VP",$rowPD["NBidon20L"]);
          $xml->addTag("Bidones12L_VP",$rowPD["NBidon12L"]);
          $xml->addTag("Bidones10L_VP",$rowPD["NBidon10L"]);
          $xml->addTag("Bidones8L_VP",$rowPD["NBidon8L"]);
          $xml->addTag("Bidones5L_VP",$rowPD["NBidon5L"]);
          $xml->addTag("PackBotellas2L_VP",$rowPD["NPackBotellas2L"]);
          $xml->addTag("PackBotellas500mL_VP",$rowPD["NPackBotellas500mL"]);
          $xml->addTag("Bidones20LBonificados_VP",$rowPD["NBidon20L_B"]);
          $xml->addTag("Bidones12LBonificados_VP",$rowPD["NBidon12L_B"]);
          $xml->addTag("Bidones10LBonificados_VP",$rowPD["NBidon10L_B"]);
          $xml->addTag("Bidones8LBonificados_VP",$rowPD["NBidon8L_B"]);
          $xml->addTag("Bidones5LBonificados_VP",$rowPD["NBidon5L_B"]);
          $xml->addTag("PackBotellas2LBonificados_VP",$rowPD["NPackBotellas2L_B"]);
          $xml->addTag("PackBotellas500mLBonificados_VP",$rowPD["NPackBotellas500mL_B"]);
        $xml->closeTag("VentaProductos");
        }
      preciosProductos($xml,$idCliente,$fecha);


      $sql = "SELECT * FROM ClientesFueraDeRecorrido WHERE IdCliente = '$idCliente' AND IdDireccion = '$idDireccion' AND IdEmpleado = '$idRepartidor' AND Fecha = '$fecha'";
      $tablaFR = $conexion->query($sql);
      if($tablaFR->num_rows>0)
        {
        $rowFR = $tablaFR->fetch_assoc();
        $xml->startTag("FueraDeRecorrido");
            $xml->addTag("IdTipoFueraDeRecorrido",$rowFR["IdFueraDeRecorrido"]);
            $xml->addTag("Mensaje",$rowFR["Mensaje"]);
        $xml->closeTag("FueraDeRecorrido");
        }


      }

  }


$xml->closeTag("Reparto");
echo $xml->toString();
?>
