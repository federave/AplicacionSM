<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');




class BidonesDispenserFC extends Generico
{

  function __construct($idCliente=null,$fecha=null)
  {

    parent::__construct();

    $this->retornables = new Retornables();
    $this->dispenserFC = 0;


    if($idCliente!=null && $fecha!=null)
        {

        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM Bidones_Servicios_Cliente WHERE IdCliente = '$idCliente' AND Fecha<='$fecha' ORDER BY Fecha DESC";
            $tablaBSC = $this->conexion->query($sql);
            if($tablaBSC->num_rows>0)
              {
              $rowBSC = $tablaBSC->fetch_assoc();
              $this->dispenserFC = $rowBSC["NDispFC"];
              $this->retornables->setBidon20L($rowBSC["NBidon20L"]);
              $this->retornables->setBidon12L($rowBSC["NBidon12L"]);
              }
            }
          }



  }




  protected $retornables;
  protected $dispenserFC;


  public function getDispenserFC(){return $this->dispenserFC;}
  public function getRetornables(){return $this->retornables;}















  ///Metodos Generico
  public function actualizar(){return true;}

  public function cargar(){return true;}
  public function guardar(){return true;}
  public function modificar(){return true;}
  public function eliminar(){return true;}
  public function getEstado(){return true;}
  public function getItem(){return new Item();}






}
?>
