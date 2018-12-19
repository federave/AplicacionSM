<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/pagosAlquileres/pagoAlquiler.php');




class PagosAlquileresDiaRepartidor extends GenericoLista
{

  function __construct($idRepartidor=null,$fecha=null)
  {
  parent::__construct();
  $this->dineroTotal=0;
  $this->size=0;
  $this->nombreItem="PagoAlquiler";
  if($idRepartidor!=null && $fecha!=null)
    {
    if(parent::abrirConexion())
      {
      $sql = "SELECT * FROM Pagos_Repartidor_Alquileres WHERE Fecha='$fecha' AND IdEmpleado='$idRepartidor'";
      $tabla = $this->conexion->query($sql);
      if($tabla->num_rows>0)
          {
          $k=0;
          while($row = $tabla->fetch_assoc())
            {
            $this->lista[$k] = new PagoAlquiler($row["IdPago"]);
            $this->dineroTotal += $this->lista[$k]->getDinero();
            $k++;
            }
          $this->size=$k;
          }
      parent::cerrarConexion();
      }
    }
  }

  protected $dineroTotal;

  public function getDineroTotal(){return $this->dineroTotal;}



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
