

<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/direccion.php');

class Observacion extends GenericoDiaRepartidor
{

      function __construct($id=null)
      {
      parent::__construct();
      if($id!=null)
        {
        $this->id = $id;
        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM ObservacionesPlanillaDinamica WHERE Id = '$id'";
            $tabla = $this->conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->idCliente = $row["IdCliente"];
                $this->idDireccion = $row["IdDireccion"];
                $this->idRepartidor = $row["IdEmpleado"];
                $this->fecha = $row["Fecha"];
                $this->observacion = $row["Observacion"];
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
      }

      protected $idCliente;
      protected $nombreCliente;
      protected $idDireccion;
      protected $datosDireccion;
      protected $idRepartidor;
      protected $fecha;
      protected $observacion;






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
     $descripcion .= $this->observacion;

     $item->setDescripcion($descripcion);

     return $item;
     }

     ///Metodos GenericoEvaluar

     public function evaluar(){return true;}
     public function getEvaluar(){return $this->evaluar;}

}

?>
