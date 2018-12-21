<?php



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











?>
