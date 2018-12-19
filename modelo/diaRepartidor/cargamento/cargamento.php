




<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/generico.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/cargamento/cargas/cargas.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/diaRepartidor/cargamento/descargas/descargas.php');


class Cargamento extends GenericoDiaRepartidor
{

 function __construct()
 {
 parent::__construct();
 $this->cargas = new Cargas();
 $this->descargas = new Descargas();
 }


    private $cargas;
    private $descargas;

    public function getCargas(){return $this->cargas;}
    public function getDescargas(){return $this->descargas;}



     ///Metodos Generico

    public function cargar()
    {
    $aux = true;
    try
      {
      $this->cargas->setRepartidor($this->repartidor);
      $this->cargas->setFecha($this->fecha);
      $this->descargas->setRepartidor($this->repartidor);
      $this->descargas->setFecha($this->fecha);
      $aux &= $this->descargas->cargar();
      $aux &= $this->cargas->cargar();

      }
    catch (Exception $e)
      {
      $aux = false;
      }
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
