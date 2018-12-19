
<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/alquiler/alquiler.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/deudaProductos/deudaProductos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/ventaProductos/ventaProductos.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/llamado/llamado.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/observaciones/observacion.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/repartos/reparto/vacios/vacios.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/cliente.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/tipoVisita.php');


class Reparto extends GenericoDiaRepartidor
{

     function __construct()
     {
     $this->ventaProductos = new VentaProductos();
     $this->deudaProductos = new DeudaProductos();
     $this->alquiler = new Alquiler();
     $this->vacios = new Vacios();
     $this->tipoVisita = new TipoVisita();
     $this->llamado = new Llamado();
     $this->observacion = new Observacion();
     $this->vendedor = new Trabajador();

     }






      private $idCliente;
      private $idDireccion;
      private $ventaProductos;
      private $deudaProductos;
      private $alquiler;
      private $vacios;
      private $tipoVisita;
      private $llamado;
      private $observacion;
      private $vendedor;








     ///Metodos Generico

     public function cargar(){return true;}





     public function guardar(){return true;}
     public function modificar(){return true;}
     public function eliminar(){return true;}
     public function getEstado(){return true;}
     public function actualizar(){return true;}
     public function getItem(){return new Item();}

     ///Metodos GenericoEvaluar

     public function evaluar(){return true;}
     public function getEvaluar(){return $this->evaluar;}

}

?>
