

<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');



class Carga extends GenericoProductos
{

 function __construct($id=null)
 {
 parent::__construct();

 if($id!=null)
   {
   if(parent::abrirConexion())
       {
       $sql = "SELECT * FROM Cargas WHERE IdCarga = '$id'";

       $tabla = $this->conexion->query($sql);

       if($tabla->num_rows>0)
           {
           $row = $tabla->fetch_assoc();
           $this->retornables->setBidon20L($row["NBidon20L"]);
           $this->retornables->setBidon12L($row["NBidon12L"]);
           $this->descartables->setBidon10L($row["NBidon10L"]);
           $this->descartables->setBidon8L($row["NBidon8L"]);
           $this->descartables->setBidon5L($row["NBidon5L"]);
           $this->descartables->setPackBotellas2L($row["NPackBotellas2L"]);
           $this->descartables->setPackBotellas500mL($row["NPackBotellas500mL"]);



           }
       }

   }



 }


     public function getPeso()
     {
     return $this->retornables->getBidon20L()*20 + $this->retornables->getBidon12L()*12 + $this->descartables->getBidon10L()*10 + $this->descartables->getBidon8L()*8 + $this->descartables->getBidon5L()*5 + $this->descartables->getPackBotellas2L()*16 + $this->descartables->getPackBotellas500mL()*9;
     }


     public function getItem()
     {
     $item = new Item();
     $descripcionOculta = "Bidones 20L: " . $this->retornables->getBidon20L();
     $descripcionOculta .= "<br>Bidones 12L: " . $this->retornables->getBidon12L();
     $descripcionOculta .= "<br>Bidones 10L: " . $this->descartables->getBidon10L();
     $descripcionOculta .= "<br>Bidones 8L: " . $this->descartables->getBidon8L();
     $descripcionOculta .= "<br>Bidones 5L: " . $this->descartables->getBidon5L();
     $descripcionOculta .= "<br>Pack Botellas 2L: " . $this->descartables->getPackBotellas2L();
     $descripcionOculta .= "<br>Pack Botellas 500mL: " . $this->descartables->getPackBotellas500mL();
     $item->setDescripcion($this->getPeso()." kg");
     $item->setDescripcionOculta($descripcionOculta);
     $item->setId($this->id);
     return $item;
     }



     ///Metodos Generico

     public function cargar(){return true;}
     public function guardar(){return true;}
     public function modificar(){return true;}
     public function eliminar(){return true;}
     public function getEstado(){return true;}
     public function actualizar(){return true;}

     ///Metodos GenericoEvaluar

     public function evaluar(){return true;}
     public function getEvaluar(){return $this->evaluar;}

}

?>
