<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/productos/productos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/precios/precios.php');



class DatosAlquiler extends Generico
{


    function __construct($idCliente=null,$fecha=null)
    {
      parent::__construct();

      $this->precioAlquileres = new PrecioAlquileres();

      $this->alquileres = new Alquileres();
      $this->alquileresPagados = new Alquileres();
      $this->retornablesEntregados = new Retornables();
      $this->estado = false;
      $this->precioEspecial = false;



      if($idCliente!=null && $fecha!=null)
          {
          $this->id = $idCliente;

          if(parent::abrirConexion())
              {

                $sql = "SELECT * FROM AcuerdosDispenser WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";

                $tablaAD = $this->conexion->query($sql);
                if($tablaAD->num_rows>0)
                    {
                    $rowAD = $tablaAD->fetch_assoc();


                    if(($rowAD["NAlq6B"] + $rowAD["NAlq8B"] + $rowAD["NAlq10B"] + $rowAD["NAlq12B"] ) > 0)
                      {

                      $this->estado = true;

                      $this->alquileres->setAlquiler6Bidones($rowAD["NAlq6B"]);
                      $this->alquileres->setAlquiler8Bidones($rowAD["NAlq8B"]);
                      $this->alquileres->setAlquiler10Bidones($rowAD["NAlq10B"]);
                      $this->alquileres->setAlquiler12Bidones($rowAD["NAlq12B"]);

                      $this->precioAlquileres = new PrecioAlquileres($fecha);


                      if(($rowAD["PrecioEspecial"] == 1) && ($rowAD["PAlq6B"]!=-1 || $rowAD["PAlq8B"]!=-1 || $rowAD["PAlq10B"]!=-1 ||$rowAD["PAlq12B"]!=-1))
                          {

                          $this->precioEspecial = true;

                          if($rowAD["PAlq6B"]!=-1)
                            {
                            $this->precioAlquileres->setAlquiler6Bidones($rowAD["PAlq6B"]);
                            }
                          if($rowAD["PAlq8B"]!=-1)
                            {
                            $this->precioAlquileres->setAlquiler8Bidones($rowAD["PAlq8B"]);
                            }
                          if($rowAD["PAlq10B"]!=-1)
                            {
                            $this->precioAlquileres->setAlquiler10Bidones($rowAD["PAlq10B"]);
                            }
                          if($rowAD["PAlq12B"]!=-1)
                            {
                            $this->precioAlquileres->setAlquiler12Bidones($rowAD["PAlq12B"]);
                            }

                          }
                        $date = strtotime($fecha);
                        $year = date("Y", $date);
                        $mes = date("m", $date);

                        $sql = "SELECT * FROM Deudas_AlquilerDispenserFC WHERE IdCliente = '$idCliente' AND Año = '$year' AND Mes = '$mes'";
                        $tablaDeudas_ADFC = $this->conexion->query($sql);

                        if($tablaDeudas_ADFC->num_rows>0)
                          {
                          $rowDeudas_ADFC = $tablaDeudas_ADFC->fetch_assoc();
                          $this->alquileresPagados->setAlquiler6Bidones($rowDeudas_ADFC["NAlq6B_P"]);
                          $this->alquileresPagados->setAlquiler8Bidones($rowDeudas_ADFC["NAlq8B_P"]);
                          $this->alquileresPagados->setAlquiler10Bidones($rowDeudas_ADFC["NAlq10B_P"]);
                          $this->alquileresPagados->setAlquiler12Bidones($rowDeudas_ADFC["NAlq12B_P"]);
                          }

                        $sql = "SELECT * FROM AlquilerDispenser_BidonesEntregados WHERE IdCliente = '$idCliente' AND Año = '$year' AND Mes = '$mes'";
                        $tablaADBE = $this->conexion->query($sql);

                        if($tablaADBE->num_rows>0)
                          {
                          $rowADBE = $tablaADBE->fetch_assoc();
                          $this->retornablesEntregados->setBidon20L($rowADBE["NBidon20L"]);
                          $this->retornablesEntregados->setBidon12L($rowADBE["NBidon12L"]);
                          }
                      }
                    }
              parent::cerrarConexion();
              }
            }

        }



  private $precioAlquileres;
  private $precioEspecial;

  private $alquileres;
  private $alquileresPagados;

  private $retornablesEntregados;


  public function getPrecioAlquileres(){return $this->precioAlquileres;}
  public function getPrecioEspecial(){return $this->precioEspecial;}
  public function getAlquileres(){return $this->alquileres;}
  public function getAlquileresPagados(){return $this->alquileresPagados;}
  public function getRetornablesEntregados(){return $this->retornablesEntregados;}













  ///Metodos Generico
  public function actualizar(){return true;}

  public function cargar(){return true;}
  public function guardar(){return true;}
  public function modificar(){return true;}
  public function eliminar(){return true;}
  public function getEstado(){return $this->estado;}
  public function getItem(){return new Item();}






}
?>
