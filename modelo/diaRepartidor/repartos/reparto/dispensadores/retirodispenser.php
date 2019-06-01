
<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/direccion.php');

class RetiroDispenser extends GenericoDiaRepartidor
{

      function __construct($idcliente,$iddireccion,$idrepartidor,$fecha)
      {
      parent::__construct();

      if(parent::abrirConexion())
          {
          $sql = "SELECT * FROM retirodispensers WHERE idcliente = '$idcliente' AND iddireccion = '$iddireccion' AND idrepartidor = '$idrepartidor' AND fecha = '$fecha'  ";
          $tabla = $this->conexion->query($sql);
          if($tabla->num_rows>0)
              {
              $row = $tabla->fetch_assoc();
              $this->idCliente = $row["idcliente"];
              $this->idDireccion = $row["iddireccion"];
              $this->idRepartidor = $row["idrepartidor"];
              $this->fecha = $row["fecha"];
              $this->cantidad = $row["cantidad"];

              }

          $sql = "SELECT Nombre,Apellido FROM Clientes WHERE IdCliente = '$this->idCliente'";
          $tabla = $this->conexion->query($sql);
          if($tabla->num_rows>0)
              {
              $row = $tabla->fetch_assoc();
              $this->nombreCliente=$row["Nombre"]." ".$row["Apellido"];
              }

          $direccion = new Direccion($this->idDireccion);
          $this->datosDireccion = $direccion->toString();


          }

      }

      protected $idCliente;
      protected $nombreCliente;
      protected $idDireccion;
      protected $datosDireccion;
      protected $idRepartidor;
      protected $fecha;
      protected $cantidad;


      public function getCantidad(){return $this->cantidad;}




     ///Metodos Generico

     public function cargar(){return true;}
     public function guardar(){return true;}
     public function modificar(){return true;}
     public function eliminar(){return true;}
     public function getEstado(){return true;}
     public function actualizar(){return true;}
     public function getItem()
     {
     $item = new Item();

     $descripcion = $this->idCliente . " " . $this->nombreCliente . " " .$this->datosDireccion;
     $descripcion .= "<br><br>";
     $descripcion .= "Cantidad: " . $this->cantidad;
     $descripcion .= "<br><br>";
     $item->setDescripcion($descripcion);

     return $item;
     }

     ///Metodos GenericoEvaluar

     public function evaluar(){return true;}
     public function getEvaluar(){return $this->evaluar;}

}

?>
