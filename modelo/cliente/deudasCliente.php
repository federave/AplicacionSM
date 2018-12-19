<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/deudaProductos/deudaProductos.php');




class DeudasProductosCliente extends GenericoLista
{

  function __construct($idCliente=null,$fecha=null)
  {
  parent::__construct();
  $this->nombreItem="Deuda Productos ";
  if($idCliente!=null && $fecha!=null)
    {
    if(parent::abrirConexion())
      {
      $sql = "SELECT * FROM Deudas_Productos WHERE IdCliente='$idCliente' AND Fecha<='$fecha' AND Estado_Deuda=1 ORDER BY Fecha Desc";
      $tabla = $this->conexion->query($sql);
      if($tabla->num_rows>0)
          {
          $k=0;
          while($row = $tabla->fetch_assoc())
            {
            $this->lista[$k] = new DeudaProductos($row["IdDeuda"]);
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
