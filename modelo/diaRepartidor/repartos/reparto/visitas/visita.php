

<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/direccion.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/tipoVisita.php');

class Visita extends GenericoDiaRepartidor
{

      function __construct($id=null)
      {
      parent::__construct();
      if($id!=null)
        {
        $this->id = $id;
        if(parent::abrirConexion())
            {

            $sql = "SELECT * FROM VisitasPlanillaDinamica WHERE Id = '$id'";
            $tabla = $this->conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->idCliente = $row["IdCliente"];
                $this->idRepartidor = $row["IdEmpleado"];
                $this->fecha = $row["Fecha"];
                $this->tipoVisita = new TipoVisita($row["IdTipoVisita"]);
                }

            $sql = "SELECT Nombre,Apellido FROM Clientes WHERE IdCliente = '$this->idCliente'";
            $tabla = $this->conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->nombreCliente=$row["Nombre"]." ".$row["Apellido"];
                }
            parent::cerrarConexion();
            }
        }
      }

      protected $idCliente;
      protected $nombreCliente;
      protected $idRepartidor;
      protected $fecha;
      protected $tipoVisita;


      public function getTipoVisita(){return $this->tipoVisita;}




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

     $descripcion = $this->idCliente . " " . $this->nombreCliente;
     $descripcion .= "<br>";
     $descripcion .= $this->tipoVisita->getTipoVisita();

     $item->setDescripcion($descripcion);

     return $item;
     }

     ///Metodos GenericoEvaluar

     public function evaluar(){return true;}
     public function getEvaluar(){return $this->evaluar;}

}

?>
