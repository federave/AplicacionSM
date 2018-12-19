
<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/cliente/direccion.php');

class PagoAlquiler extends GenericoAlquiler
{

      function __construct($id=null)
      {
      parent::__construct();
      if($id!=null)
        {
        $this->id = $id;
        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM Pagos_Repartidor_Alquileres WHERE IdPago = '$id'";
            $tabla = $this->conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->idCliente = $row["IdCliente"];
                $this->idRepartidor = $row["IdEmpleado"];
                $this->fecha = $row["Fecha"];
                $this->dinero = $row["DineroTotal"];


                $this->alquileres->setAlquiler6Bidones($row["NAlq6B"]);
                $this->alquileres->setAlquiler8Bidones($row["NAlq8B"]);
                $this->alquileres->setAlquiler10Bidones($row["NAlq10B"]);
                $this->alquileres->setAlquiler12Bidones($row["NAlq12B"]);


                }

            $sql = "SELECT Nombre,Apellido FROM Clientes WHERE IdCliente = '$this->idCliente'";
            $tabla = $this->conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->nombreCliente=$row["Nombre"]." ".$row["Apellido"];
                }



            }
        }
      }

      protected $idCliente;
      protected $nombreCliente;
      protected $idRepartidor;
      protected $fecha;
      protected $dinero;

      public function getDinero(){return $this->dinero;}





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
     $descripcion .= "<br><br>Dinero: " . $this->dinero . "<br>";

     if($this->alquileres->getAlquiler6Bidones()>0)
        $descripcion .= "<br>Alquileres de 6 Bidones Pagados: " . $this->alquileres->getAlquiler6Bidones();
     if($this->alquileres->getAlquiler8Bidones()>0)
        $descripcion .= "<br>Alquileres de 8 Bidones Pagados: " . $this->alquileres->getAlquiler8Bidones();
     if($this->alquileres->getAlquiler10Bidones()>0)
        $descripcion .= "<br>Alquileres de 10 Bidones Pagados: " . $this->alquileres->getAlquiler10Bidones();
     if($this->alquileres->getAlquiler12Bidones()>0)
        $descripcion .= "<br>Alquileres de 12 Bidones Pagados: " . $this->alquileres->getAlquiler12Bidones();
     $descripcion .="<br>";

     $item->setDescripcion($descripcion);

     return $item;
     }

     ///Metodos GenericoEvaluar

     public function evaluar(){return true;}
     public function getEvaluar(){return $this->evaluar;}

}

?>
