<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/observaciones/observacion.php');




class ObservacionesClienteDiaRepartidor extends GenericoLista
{

  function __construct($idRepartidor=null,$fecha=null)
  {
  parent::__construct();
  $this->nombreItem="Observacion";
  if($idRepartidor!=null && $fecha!=null)
    {
    if(parent::abrirConexion())
      {
      $sql = "SELECT * FROM ObservacionesPlanillaDinamica WHERE Fecha='$fecha' AND IdEmpleado='$idRepartidor'";
      $tabla = $this->conexion->query($sql);
      if($tabla->num_rows>0)
          {
          $k=0;
          while($row = $tabla->fetch_assoc())
            {
            $this->lista[$k] = new Observacion($row["Id"]);
            $k++;
            }
          $this->size=$k;
          }
      }
    }
  }




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
