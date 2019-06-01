<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/dispensadores/entregadispenser.php');




class EntregasDispensers extends GenericoLista
{

  function __construct($idRepartidor=null,$fecha=null)
  {
  parent::__construct();
  $this->nombreItem="EntregaDispenser";
  if($idRepartidor!=null && $fecha!=null)
    {
    if(parent::abrirConexion())
      {

      $sql = "SELECT * FROM entregadispensers WHERE fecha='$fecha' AND idrepartidor='$idRepartidor'";
      $tabla = $this->conexion->query($sql);
      if($tabla->num_rows>0)
          {
          $k=0;
          $this->dinero=0;
          while($row = $tabla->fetch_assoc())
            {
            $this->lista[$k] = new EntregaDispenser($row["idcliente"],$row["iddireccion"],$row["idrepartidor"],$fecha);
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
