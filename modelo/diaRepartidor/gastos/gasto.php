
<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');

class Gasto extends GenericoDiaRepartidor
{


      function __construct($id=null)
      {
      parent::__construct();
      if($id!=null)
        {
        $this->id = $id;
        if(parent::abrirConexion())
            {
            $sql = "SELECT * FROM Gastos_Repartidor WHERE IdGasto = '$id'";
            $tabla = $this->conexion->query($sql);
            if($tabla->num_rows>0)
                {
                $row = $tabla->fetch_assoc();
                $this->combustible = $row["Combustible"];
                $this->otros = $row["Otros"];
                $this->descripcion = $row["Descripcion"];
                $this->dinero = $row["DineroGastado"];
                }
            }
        }
      }



     private $combustible;
     private $otros;
     private $descripcion;
     private $dinero;

     public function getCombustible(){return $this->combustible;}
     public function getOtros(){return $this->otros;}
     public function getDescripcion(){return $this->descripcion;}
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

     $dineroGastado="<br>Dinero: " . $this->dinero;
     if($this->combustible)
      $descripcion="Combustible";
     else
     $descripcion=$this->descripcion;

     $item = new Item();
     $item->setDescripcion($descripcion.$dineroGastado);
     $item->setId($this->id);


     return $item;
     }

     ///Metodos GenericoEvaluar

     public function evaluar(){return true;}
     public function getEvaluar(){return $this->evaluar;}

}

?>
