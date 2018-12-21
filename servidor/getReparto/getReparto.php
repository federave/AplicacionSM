<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');
include_once('../../modelo/precios/precios.php');
include_once('precioProductos.php');
include_once('datosCliente.php');



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

  $sql = "SELECT * FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$fecha' AND Orden='$cliente'";
  $tablaPD = $conexion->query($sql);

  if($tablaPD->num_rows>0)
      {
        $rowPD = $tablaPD->fetch_assoc();


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



/*
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
      */









  }


$xml->closeTag("Reparto");
echo $xml->toString();
?>
