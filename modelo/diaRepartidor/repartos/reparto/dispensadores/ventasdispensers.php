<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/dispensadores/ventadispenser.php');




class VentasDispensers extends GenericoLista
{

  function __construct($idRepartidor=null,$fecha=null)
  {
  parent::__construct();
  $this->nombreItem="VentaDispenser";
  if($idRepartidor!=null && $fecha!=null)
    {
    if(parent::abrirConexion())
      {

      $precioDispensadores = new PrecioDispensadores($fecha);

      $sql = "SELECT * FROM ventadispensers WHERE fecha='$fecha' AND idrepartidor='$idRepartidor'";
      $tabla = $this->conexion->query($sql);
      if($tabla->num_rows>0)
          {
          $k=0;
          $this->dinero=0;
          while($row = $tabla->fetch_assoc())
            {

            $ventaDispenser = new VentaDispenser($row["idcliente"],$row["iddireccion"],$row["idrepartidor"],$fecha);
            $this->lista[$k] = $ventaDispenser;

            if($ventaDispenser->getEspecial())
              $this->dinero += $ventaDispenser->getCantidad()*$ventaDispenser->getPrecioEspecial();
            else
              $this->dinero += $ventaDispenser->getCantidad()*$precioDispensadores->getVertedor();



            $k++;
            }
          $this->size=$k;
          }
      }
    }
  }

  protected $dinero;

  public function getDinero(){return $this->dinero;}




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
