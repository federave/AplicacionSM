



<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/gastos/gasto.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');


class Gastos extends GenericoLista
{

     function __construct()
     {

       parent::__construct();

     $this->nombreItem = "Gasto";

     }




     private $dinero = 0;

     public function getDinero(){return $this->dinero;}



     ///Metodos Generico

     public function cargar()
     {
     $aux = false;


     if(parent::abrirConexion())
         {


         $aux=true;
         $idRepartidor = $this->repartidor->getId();



         $sql = "SELECT * FROM Gastos_Repartidor WHERE IdEmpleado = '$idRepartidor' AND Fecha = '$this->fecha'";
         $tabla= $this->conexion->query($sql);
         if($tabla->num_rows>0)
             {
             $k=0;
             while($row = $tabla->fetch_assoc())
               {
               $gasto = new Gasto($row["IdGasto"]);
               $this->lista[$k] = $gasto;
               $this->dinero += $gasto->getDinero();
               $k++;
               }
             $this->size=$k;
             }
         parent::cerrarConexion();
         }
     return $aux;
     }

     private $sql;
     public function getSQL(){return $this->sql;}

     ///Metodos Generico




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
