
<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/productos/productos.php');



class Descarga extends GenericoProductos
{


   function __construct($id=null)
   {
   parent::__construct();

   $this->retornablesVacios = new Retornables();

   if($id!=null)
     {
     $this->id = $id;
     if(parent::abrirConexion())
         {
         $sql = "SELECT * FROM Descargas WHERE IdDescarga = '$id'";

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
             $this->retornablesVacios->setBidon20L($row["NBidon20L_V"]);
             $this->retornablesVacios->setBidon12L($row["NBidon12L_V"]);

             }

         parent::cerrarConexion();
         }

     }

    }

     private $retornablesVacios;
     public function getRetornablesVacios(){return $this->retornablesVacios;}


     ///Metodos Generico

     public function cargar(){return true;}
     public function guardar()
     {
     $aux = false;
     if(parent::abrirConexion())
         {
         $idRepartidor = $this->repartidor->getId();
         $bidones20L = $this->retornables->getBidon20L();
         $bidones12L = $this->retornables->getBidon12L();
         $bidones10L = $this->descartables->getBidon10L();
         $bidones8L = $this->descartables->getBidon8L();
         $bidones5L = $this->descartables->getBidon5L();
         $packBotellas2L = $this->descartables->getPackBotellas2L();
         $packBotellas500mL = $this->descartables->getPackBotellas500mL();
         $bidones20LVacios = $this->retornablesVacios->getBidon20L();
         $bidones12LVacios = $this->retornablesVacios->getBidon12L();
         $this->sql = "INSERT INTO Descargas(IdEmpleado,Fecha,NBidon20L,NBidon12L,NBidon10L,NBidon8L,NBidon5L,NPackBotellas2L,NPackBotellas500mL,NBidon20L_V,NBidon12L_V,NDispFC,NDispNat) VALUES ('$idRepartidor','$this->fecha','$bidones20L','$bidones12L','$bidones10L','$bidones8L','$bidones5L','$packBotellas2L','$packBotellas500mL','$bidones20LVacios','$bidones12LVacios',0,0)";
         $aux = $this->conexion->query($this->sql);
         parent::cerrarConexion();
         }
     return $aux;
     }

     private $sql;

     public function getSQL(){return $this->sql;}



     public function modificar(){return true;}
     public function eliminar()
     {
     $aux = false;
     if(parent::abrirConexion())
        {
        $this->sql = "DELETE FROM Descargas WHERE IdDescarga = '$this->id'";
        $aux = $this->conexion->query($this->sql);
        parent::cerrarConexion();
        }
     return $aux;
     }

     public function getEstado(){return true;}
     public function actualizar(){return true;}
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
     $descripcionOculta .= "<br>Bidones 20L Vacios: " . $this->retornablesVacios->getBidon20L();
     $descripcionOculta .= "<br>Bidones 12L Vacios: " . $this->retornablesVacios->getBidon12L();
     $item->setDescripcion($this->getPeso()." kg");
     $item->setDescripcionOculta($descripcionOculta);
     $item->setId($this->id);

     return $item;
     }

     public function getPeso()
     {
     return $this->retornables->getBidon20L()*20 + $this->retornables->getBidon12L()*12 + $this->descartables->getBidon10L()*10 + $this->descartables->getBidon8L()*8 + $this->descartables->getBidon5L()*5 + $this->descartables->getPackBotellas2L()*16 + $this->descartables->getPackBotellas500mL()*9;
     }

     ///Metodos GenericoEvaluar

     public function evaluar(){return true;}
     public function getEvaluar(){return $this->evaluar;}

}

?>
