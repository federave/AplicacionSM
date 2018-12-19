

<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/cargamento/descargas/descarga.php');

class Descargas extends GenericoListaProductos
{

     function __construct()
     {
     parent::__construct();
     $this->retornablesVacios = new Retornables();
     $this->nombreItem = "Descarga";
     }



     private $retornablesVacios;



     public function getRetornablesVacios(){return $this->retornablesVacios;}


     ///Metodos Generico

     public function cargar()
     {
     $aux = false;
     if(parent::abrirConexion())
         {
         $aux=true;
         $idRepartidor = $this->repartidor->getId();
         $sql = "SELECT * FROM Descargas WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$this->fecha'";
         $tabla= $this->conexion->query($sql);
         if($tabla->num_rows>0)
             {
             $k=0;
             while($row = $tabla->fetch_assoc())
               {
               $descarga = new Descarga($row["IdDescarga"]);
               $this->lista[$k] = $descarga;
               $k++;
               $this->retornables->add($descarga->getRetornables());
               $this->descartables->add($descarga->getDescartables());
               $this->retornablesVacios->add($descarga->getRetornablesVacios());
               }
             $this->size=$k;
             }
         parent::cerrarConexion();
         }
     return $aux;
     }


     public function toString()
     {
     $aux = parent::toString();
     $aux .= "<br>Bidones 20L Vacios: " . $this->retornablesVacios->getBidon20L();
     $aux .= "<br>Bidones 12L Vacios: " . $this->retornablesVacios->getBidon12L();
     return $aux;
     }




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
