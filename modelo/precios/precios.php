<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');



class PrecioDispensadores extends Conector
{


      function __construct($fecha=null)
      {
      parent::__construct();

      if($fecha!=null)
        {
        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM PreciosDispensadores WHERE Fecha <= '$fecha' ORDER BY Fecha DESC ";
            $tabla = $this->conexion->query($sql);

            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->vertedor = $row["vertedor"];
                $this->dispenser = $row["dispenser"];
                }
            }
        }


      }

      private $vertedor;
      private $dispenser;

      public function getVertedor()
      {
      return $this->vertedor;
      }
      public function getDispenser()
      {
      return $this->dispenser;
      }

      public function setVertedor($precio)
      {
      $this->vertedor = $precio;
      }
      public function setDispenser($precio)
      {
      $this->dispenser = $precio;
      }




}

class PrecioAlquileres extends Conector
{


      function __construct($fecha=null)
      {
      parent::__construct();

      if($fecha!=null)
        {
        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM PreciosProductos WHERE Fecha <= '$fecha' ORDER BY Fecha DESC ";
            $tabla = $this->conexion->query($sql);

            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->alquiler6Bidones = $row["Alquiler6Bidones"];
                $this->alquiler8Bidones = $row["Alquiler8Bidones"];
                $this->alquiler10Bidones = $row["Alquiler10Bidones"];
                $this->alquiler12Bidones = $row["Alquiler12Bidones"];
                }
            }
        }


      }

      private $alquiler6Bidones;
      private $alquiler8Bidones;
      private $alquiler10Bidones;
      private $alquiler12Bidones;

      public function getAlquiler6Bidones()
      {
      return $this->alquiler6Bidones;
      }
      public function getAlquiler8Bidones()
      {
      return $this->alquiler8Bidones;
      }
      public function getAlquiler10Bidones()
      {
      return $this->alquiler10Bidones;
      }
      public function getAlquiler12Bidones()
      {
      return $this->alquiler12Bidones;
      }

      public function setAlquiler6Bidones($precio)
      {
      $this->alquiler6Bidones = $precio;
      }
      public function setAlquiler8Bidones($precio)
      {
      $this->alquiler8Bidones = $precio;
      }
      public function setAlquiler10Bidones($precio)
      {
      $this->alquiler10Bidones = $precio;
      }
      public function setAlquiler12Bidones($precio)
      {
      $this->alquiler12Bidones = $precio;
      }



}

class PrecioRetornables extends Conector
{


      function __construct($fecha=null)
      {
      parent::__construct();

      if($fecha!=null)
        {
        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM PreciosProductos WHERE Fecha <= '$fecha' ORDER BY Fecha DESC ";
            $tabla = $this->conexion->query($sql);

            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->bidon20L = $row["Bidon20L"];
                $this->bidon12L = $row["Bidon12L"];
                }
            }
        }


      }

      private $bidon20L;
      private $bidon12L;


      public function getBidon20L()
      {
      return $this->bidon20L;
      }
      public function getBidon12L()
      {
      return $this->bidon12L;
      }


      public function setBidon20L($precio)
      {
      $this->bidon20L = $precio;
      }
      public function setBidon12L($precio)
      {
      $this->bidon12L = $precio;
      }




}





class PrecioDescartables extends Conector
{


      function __construct($fecha=null)
      {
      parent::__construct();

      if($fecha!=null)
        {
        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM PreciosProductos WHERE Fecha <= '$fecha' ORDER BY Fecha DESC ";
            $tabla = $this->conexion->query($sql);

            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->bidon10L = $row["Bidon10L"];
                $this->bidon8L = $row["Bidon8L"];
                $this->bidon5L = $row["Bidon5L"];
                $this->packBotellas2L = $row["PackBotellas2L"];
                $this->packBotellas500mL = $row["PackBotellas500mL"];
                }
            }
        }


      }

      private $bidon10L;
      private $bidon8L;
      private $bidon5L;
      private $packBotellas2L;
      private $packBotellas500mL;

      public function getBidon10L()
      {
      return $this->bidon10L;
      }
      public function getBidon8L()
      {
      return $this->bidon8L;
      }
      public function getBidon5L()
      {
      return $this->bidon5L;
      }
      public function getPackBotellas2L()
      {
      return $this->packBotellas2L;
      }
      public function getPackBotellas500mL()
      {
      return $this->packBotellas500mL;
      }

      public function setBidon10L($precio)
      {
      $this->bidon10L = $precio;
      }
      public function setBidon8L($precio)
      {
      $this->bidon8L = $precio;
      }
      public function setBidon5L($precio)
      {
      $this->bidon5L = $precio;
      }
      public function setPackBotellas2L($precio)
      {
      $this->packBotellas2L = $precio;
      }
      public function setPackBotellas500mL($precio)
      {
      $this->packBotellas500mL = $precio;
      }



}







class PrecioProductos extends Conector
{


  function __construct($fecha=null,$idCliente=null)
  {
  parent::__construct();

  if($fecha!=null && $idCliente == null)
    {
    $this->precioRetornables = new PrecioRetornables($fecha);
    $this->precioDescartables = new PrecioDescartables($fecha);
    }
  else if($fecha!=null && $idCliente != null)
    {

      $this->precioEspecial = false;


      if(parent::abrirConexion())
        {
        $conexion = $this->conexion;

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

                      $this->precioEspecial = true;

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
                          $this->precioEspecial = true;
                          if($rowAD["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowAD["PBidon20L"]);}
                          if($rowAD["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowAD["PBidon12L"]);}

                          }
                        }
                      elseif($rowAD["PrecioEspecial"] == 0 && $rowTAC["PrecioEspecial"] == 1)
                        {
                        $this->precioEspecial = true;

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
                    $this->precioEspecial = true;
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
                    $this->precioEspecial = true;
                    if($rowAD["PBidon20L"]!=-1){$precioRetornables->setBidon20L($rowAD["PBidon20L"]);}
                    if($rowAD["PBidon12L"]!=-1){$precioRetornables->setBidon12L($rowAD["PBidon12L"]);}
                    }
                  }
                }
              }
            else
              {

              }
            }

        $this->precioRetornables = $precioRetornables;
        $this->precioDescartables = $precioDescartables;




        }

    }
  else{}


  }

  private $precioEspecial;

  public function getPrecioEspecial()
  {
  return $this->precioEspecial;
  }

  private $precioRetornables;
  private $precioDescartables;

  public function getPrecioRetornables()
  {
  return $this->precioRetornables;
  }

  public function setPrecioRetornables($precioRetornables)
  {
  $this->precioRetornables = $precioRetornables;
  }

  public function getPrecioDescartables()
  {
  return $this->precioDescartables;
  }

  public function setPrecioDescartables($precioDescartables)
  {
  $this->precioDescartables = $precioDescartables;
  }




}




















?>
