<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/tipoVisita.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/visitas/visita.php');




class Visitas extends GenericoLista
{

  function __construct($idRepartidor=null,$fecha=null)
  {
  parent::__construct();
  $this->totalVisitados=0;
  $this->totalNoVisitados=0;
  $this->totalNoEncontrados=0;
  $this->nombreItem="Visita";
  $this->size=0;
  if($idRepartidor!=null && $fecha!=null)
    {
    if(parent::abrirConexion())
      {
      $sql = "SELECT * FROM VisitasPlanillaDinamica WHERE Fecha='$fecha' AND IdEmpleado='$idRepartidor'";
      $tabla = $this->conexion->query($sql);
      if($tabla->num_rows>0)
          {
          $k=0;
          while($row = $tabla->fetch_assoc())
            {
            $visita = new Visita($row["Id"]);
            $this->lista[$k] = $visita;

            if($visita->getTipoVisita()->getId() == 1)
              $this->totalVisitados++;
            else if($visita->getTipoVisita()->getId() == 3)
              $this->totalNoEncontrados++;
            else
              $this->totalNoVisitados++;

            $k++;
            }
          $this->size=$k;
          }
      parent::cerrarConexion();
      }
    }
  }

  protected $totalVisitados;
  protected $totalNoVisitados;
  protected $totalNoEncontrados;

  public function getVisitados(){return $this->totalVisitados;}
  public function getNoVisitados(){return $this->totalNoVisitados;}
  public function getNoEncontrados(){return $this->totalNoEncontrados;}


  ///Metodos Generico
  public function actualizar(){return true;}

  public function cargar(){return true;}
  public function guardar(){return true;}
  public function modificar(){return true;}
  public function eliminar(){return true;}
  public function getEstado(){return true;}
  public function getItem(){return new Item();}


   ///Metodos GenericoEvaluar

   public function evaluar(){return true;}
   public function getEvaluar(){return $this->evaluar;}





}
?>
