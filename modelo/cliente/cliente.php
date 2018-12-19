<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/direccion.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/datos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/inactividad.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/bidonesDispenserFC.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/precios/precios.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/deudasCliente.php');






class Cliente extends Generico
{

  function __construct($id=null,$id2=null)
  {
  $this->direccion = new Direccion();
  $this->datos = new Datos();
  $this->inactividad = new Inactividad();
  $this->precioProductos = new PrecioProductos();
  $this->bidonesDispenserFC = new BidonesDispenserFC();


  if($id!=null && $id2!=null)
    {

      $fecha = date('Y-m-d');

      $this->id = $id;


      $this->direccion = new Direccion($id2);
      $this->datos = new Datos($id,$id2,$fecha);
      $this->inactividad = new Inactividad($id,$fecha);
      $this->precioProductos = new PrecioProductos($fecha,$id);
      $this->bidonesDispenserFC = new BidonesDispenserFC($id,$fecha);
      $this->deudasProductos = new DeudasProductosCliente($id,$fecha);



    }




  }




  private $datos;
  private $direccion;
  private $inactividad;
  private $precioProductos;
  private $bidonesDispenserFC;
  private $deudasProductos;


  public function getDatos(){return $this->datos;}
  public function getDireccion(){return $this->direccion;}
  public function getInactividad(){return $this->inactividad;}
  public function getPrecioProductos(){return $this->precioProductos;}
  public function getBidonesDispenserFC(){return $this->bidonesDispenserFC;}
  public function getDeudasProductos(){return $this->deudasProductos;}












  ///Metodos Generico

  public function cargar(){return true;}
  public function guardar(){return true;}
  public function modificar(){return true;}
  public function eliminar(){return true;}
  public function getEstado(){return true;}
  public function actualizar(){return true;}
  public function getItem(){return new Item();}






}
?>
