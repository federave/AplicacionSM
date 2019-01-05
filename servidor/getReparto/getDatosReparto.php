<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');


$idRepartidor = $_GET["idRepartidor"];
$fecha = $_GET["fecha"];
$idCliente = $_GET["idCliente"];
$idDireccion = $_GET["idDireccion"];

$xml = new Xml();
$xml->startTag("DatosReparto");

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  $sql = "SELECT * FROM PlanillaDinamica WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$fecha' AND IdCliente='$idCliente' AND IdDireccion='$idDireccion'";
  $tablaPD = $conexion->query($sql);

  if($tablaPD->num_rows>0)
      {
      $rowPD = $tablaPD->fetch_assoc();

      if($rowPD["IdEmpleado_Vendedor"]!=-1)
        {
        $xml->startTag("Vendedor");
            $xml->addTag("IdVendedor",$rowPD["IdEmpleado_Vendedor"]);
        $xml->closeTag("Vendedor");
        }

      if($rowPD["NBidon20L"] > 0 || $rowPD["NBidon12L"] > 0 || $rowPD["NBidon10L"] > 0 || $rowPD["NBidon8L"] > 0 || $rowPD["NBidon5L"] > 0 || $rowPD["NPackBotellas2L"] > 0 || $rowPD["NPackBotellas500mL"] > 0 )
        {
        $xml->startTag("VentaProductos");

          if($rowPD["NBidon20L"] > 0)
            $xml->addTag("Bidones20L_VP",$rowPD["NBidon20L"]);

          if($rowPD["NBidon12L"] > 0)
            $xml->addTag("Bidones12L_VP",$rowPD["NBidon12L"]);

          if($rowPD["NBidon10L"] > 0)
            $xml->addTag("Bidones10L_VP",$rowPD["NBidon10L"]);

          if($rowPD["NBidon8L"] > 0)
            $xml->addTag("Bidones8L_VP",$rowPD["NBidon8L"]);

          if($rowPD["NBidon5L"] > 0)
            $xml->addTag("Bidones5L_VP",$rowPD["NBidon5L"]);

          if($rowPD["NPackBotellas2L"] > 0)
            $xml->addTag("PackBotellas2L_VP",$rowPD["NPackBotellas2L"]);

          if($rowPD["NPackBotellas500mL"] > 0)
            $xml->addTag("PackBotellas500mL_VP",$rowPD["NPackBotellas500mL"]);

          if($rowPD["NBidon20L_B"] > 0)
            $xml->addTag("Bidones20LBonificados_VP",$rowPD["NBidon20L_B"]);

          if($rowPD["NBidon12L_B"] > 0)
            $xml->addTag("Bidones12LBonificados_VP",$rowPD["NBidon12L_B"]);

          if($rowPD["NBidon10L_B"] > 0)
            $xml->addTag("Bidones10LBonificados_VP",$rowPD["NBidon10L_B"]);

          if($rowPD["NBidon8L_B"] > 0)
            $xml->addTag("Bidones8LBonificados_VP",$rowPD["NBidon8L_B"]);

          if($rowPD["NBidon5L_B"] > 0)
            $xml->addTag("Bidones5LBonificados_VP",$rowPD["NBidon5L_B"]);

          if($rowPD["NPackBotellas2L_B"] > 0)
            $xml->addTag("PackBotellas2LBonificados_VP",$rowPD["NPackBotellas2L_B"]);

          if($rowPD["NPackBotellas500mL_B"] > 0)
            $xml->addTag("PackBotellas500mLBonificados_VP",$rowPD["NPackBotellas500mL_B"]);

        $xml->closeTag("VentaProductos");
        }


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
  $conector->cerrarConexion();
  }

$xml->closeTag("DatosReparto");
echo $xml->toString();
?>
