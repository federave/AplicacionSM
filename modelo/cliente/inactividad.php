<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/tipoInactivo.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/productos/productos.php');

function diferenciaDias($fecha1,$fecha2)
{
$date1 = new DateTime($fecha1);
$date2 = new DateTime($fecha2);
$diff = $date1->diff($date2);
return $diff->days;
}



class Inactividad extends Generico
{

  function __construct($idCliente=null,$fecha=null)
  {
  parent::__construct();

  $this->tipoInactivo = new TipoInactivo();
  $this->retornables = new Retornables();
  $this->descartables = new Descartables();


  if(parent::abrirConexion())
      {
      $sql = "SELECT * FROM PlanillaDinamica WHERE IdCliente = '$idCliente' AND Fecha < '$fecha' AND Estado_ClienteAtendido = 1 ORDER BY Fecha DESC";
      $tablaPD = $this->conexion->query($sql);
      if($tablaPD->num_rows>0)
          {
          $k=0;
          $rowPD = $tablaPD->fetch_assoc();
          $k++;
          $fechaConsumo = $rowPD["Fecha"];


          if($rowPD["NBidon20L_A"] > 0 || $rowPD["NBidon12L_A"] > 0 || $rowPD["NBidon20L"] > 0 || $rowPD["NBidon12L"] > 0 || $rowPD["NBidon10L"] > 0 || $rowPD["NBidon8L"] > 0 || $rowPD["NBidon5L"] > 0 || $rowPD["NPackBotellas2L"] > 0 || $rowPD["NPackBotellas500mL"] > 0 )
            {
            $consumo=true;
            $this->retornables->setBidon20L($rowPD["NBidon20L"]+$rowPD["NBidon20L_A"]);
            $this->retornables->setBidon12L($rowPD["NBidon12L"]+$rowPD["NBidon12L_A"]);
            $this->descartables->setBidon10L($rowPD["NBidon10L"]);
            $this->descartables->setBidon8L($rowPD["NBidon8L"]);
            $this->descartables->setBidon5L($rowPD["NBidon5L"]);
            $this->descartables->setPackBotellas2L($rowPD["NPackBotellas2L"]);
            $this->descartables->setPackBotellas500mL($rowPD["NPackBotellas500mL"]);
            }
          else
            {$consumo=false;}

          while($consumo == false && $k < $tablaPD->num_rows)
              {
              $rowPD = $tablaPD->fetch_assoc();
              $k++;
              $fechaConsumo = $rowPD["Fecha"];
              if($rowPD["NBidon20L_A"] > 0 || $rowPD["NBidon12L_A"] > 0 || $rowPD["NBidon20L"] > 0 || $rowPD["NBidon12L"] > 0 || $rowPD["NBidon10L"] > 0 || $rowPD["NBidon8L"] > 0 || $rowPD["NBidon5L"] > 0 || $rowPD["NPackBotellas2L"] > 0 || $rowPD["NPackBotellas500mL"] > 0 )
                {
                $consumo=true;
                $this->retornables->setBidon20L($rowPD["NBidon20L"]+$rowPD["NBidon20L_A"]);
                $this->retornables->setBidon12L($rowPD["NBidon12L"]+$rowPD["NBidon12L_A"]);
                $this->descartables->setBidon10L($rowPD["NBidon10L"]);
                $this->descartables->setBidon8L($rowPD["NBidon8L"]);
                $this->descartables->setBidon5L($rowPD["NBidon5L"]);
                $this->descartables->setPackBotellas2L($rowPD["NPackBotellas2L"]);
                $this->descartables->setPackBotellas500mL($rowPD["NPackBotellas500mL"]);
                }
              else
                {$consumo=false;}
              }

            if(diferenciaDias($fecha,$fechaConsumo)<10)
              {
              $this->tipoInactivo = new TipoInactivo(2);
              }//hace 10 dias
            elseif (diferenciaDias($fecha,$fechaConsumo)<20)
              {
              $this->tipoInactivo = new TipoInactivo(3);
              }//hace mas de 10 dias y menos de 20 luz amarilla
            else
              {
              $this->tipoInactivo = new TipoInactivo(4);
              }//hace mas de 20 dias luz roja

              $this->fechaConsumo = $fechaConsumo;



            }
          else
            {
            $this->tipoInactivo = new TipoInactivo(5);//cliente nuevo
            }
          parent::cerrarConexion();
          }

  }



  private $tipoInactivo;
  private $fechaConsumo;
  private $retornables;
  private $descartables;

  public function getTipoInactivo(){return $this->tipoInactivo;}
  public function getRetornables(){return $this->retornables;}
  public function getDescartables(){return $this->descartables;}
  public function getFechaUltimoConsumo(){return $this->fechaConsumo;}

  public function getConsumo(){return $this->retornables->have() || $this->descartables->have();}

  //public function getConsumo(){return true;}









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
