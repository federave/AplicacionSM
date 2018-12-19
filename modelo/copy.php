<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');

class ClassName extends Generico
{

  function __construct()
  {
    # code...
  }

  ///Metodos Generico

  public function cargar(){return true;}
  public function guardar(){return true;}
  public function modificar(){return true;}
  public function eliminar(){return true;}
  public function getEstado(){return true;}
  public function actualizar(){return true;}

  public function getItem(){return new Item();}






}
?>










<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');

class ClassName extends GenericoEvaluar
{

 function __construct()
 {
   # code...
 }

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






<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');

class ClassName extends GenericoDiaRepartidor
{

 function __construct()
 {
   # code...
 }

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







<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');



class ClassName extends GenericoProductos
{

 function __construct()
 {
   # code...
 }

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






<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');



class ClassName extends GenericoRetornables
{

 function __construct()
 {
   # code...
 }

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
