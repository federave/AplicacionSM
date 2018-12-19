<?php


include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/otros/otros.php');


abstract class Generico extends Conector
{

    function __construct()
    {
    parent::__construct();
    }


    abstract protected function cargar();
    abstract protected function guardar();
    abstract protected function modificar();
    abstract protected function eliminar();
    abstract protected function getEstado();
    abstract protected function actualizar();
    abstract protected function getItem();



    protected $estado;

    protected $id;

    public function getId()
    {
    return $this->id;
    }

    public function setId($id)
    {
    return $this->id = $id;
    }



}




abstract class GenericoEvaluar extends Generico
{

    function __construct()
    {
    parent::__construct();
    }

    abstract protected function evaluar();
    abstract protected function getEvaluar();

    protected $evaluar="";


}


abstract class GenericoDiaRepartidor extends GenericoEvaluar
{

    function __construct()
    {
    parent::__construct();
    }


    protected $repartidor;
    protected $fecha;
    protected $idDiaRepartidor;

    public function getRepartidor()
    {
    return $this->repartidor;
    }

    public function setRepartidor($repartidor)
    {
    return $this->repartidor = $repartidor;
    }

    public function getIdDiaRepartidor()
    {
    return $this->idDiaRepartidor;
    }

    public function setIdDiaRepartidor($idDiaRepartidor)
    {
    return $this->idDiaRepartidor = $idDiaRepartidor;
    }

    public function getFecha()
    {
    return $this->fecha;
    }

    public function setFecha($fecha)
    {
    return $this->fecha = $fecha;
    }


}

abstract class GenericoLista extends GenericoDiaRepartidor
{

    function __construct()
    {
    parent::__construct();
    }

    protected $lista = array();
    protected $size=0;
    protected $nombreItem="";


    public function get($indice){return $this->lista[$indice];}
    public function getSize(){return $this->size;}


    public function getItems()
    {

    $items = new Items();
    $k=0;
    while($k < $this->size)
      {
      $item = $this->lista[$k]->getItem();
      $item->setTitulo($this->nombreItem. ($k + 1) );
      $items->addItem($item);
      $k++;
      }
    return $items;
    }

}

abstract class GenericoRetornables extends GenericoDiaRepartidor
{

    function __construct()
    {
    parent::__construct();
    $this->retornables = new Retornables();
    }

    protected $retornables;

    public function have()
    {
    return $this->retornables->have();
    }



    public function getRetornables()
    {
    return $this->retornables;
    }

    public function setRetornables($retornables)
    {
    return $this->retornables = $retornables;
    }



}


abstract class GenericoDineroRetornables extends GenericoRetornables
{

    function __construct()
    {
    parent::__construct();
    }


    protected $dinero;

    public function getDinero()
    {
    return $this->dinero;
    }




}


abstract class GenericoProductos extends GenericoDiaRepartidor
{

    function __construct()
    {
    parent::__construct();
    $this->retornables = new Retornables();
    $this->descartables = new Descartables();
    }


    protected $retornables;
    protected $descartables;


    public function toString()
    {
    $aux = "Bidones 20L: " . $this->retornables->getBidon20L();
    $aux .= "<br>Bidones 12L: " . $this->retornables->getBidon12L();
    $aux .= "<br>Bidones 10L: " . $this->descartables->getBidon10L();
    $aux .= "<br>Bidones 8L: " . $this->descartables->getBidon8L();
    $aux .= "<br>Bidones 5L: " . $this->descartables->getBidon5L();
    $aux .= "<br>Pack Botellas 2L: " . $this->descartables->getPackBotellas2L();
    $aux .= "<br>Pack Botellas 500mL: " . $this->descartables->getPackBotellas500mL();
    return $aux;
    }



    public function have()
    {
    return $this->retornables->have() || $this->descartables->have();
    }



    public function getRetornables()
    {
    return $this->retornables;
    }

    public function setRetornables($retornables)
    {
    return $this->retornables = $retornables;
    }

    public function getDescartables()
    {
    return $this->descartables;
    }

    public function setDescartables($descartables)
    {
    return $this->descartables = $descartables;
    }


}

abstract class GenericoListaProductos extends GenericoProductos
{

    function __construct()
    {
    parent::__construct();
    }

    protected $lista = array();
    protected $size=0;

    public function get($indice){return $this->lista[$indice];}
    public function getSize(){return $this->size;}


    public function getItems()
    {

    $items = new Items();
    $k=0;
    while($k < $this->size)
      {
      $item = $this->lista[$k]->getItem();
      $item->setTitulo($this->nombreItem. ($k + 1) );
      $items->addItem($item);
      $k++;
      }
    return $items;
    }


}

abstract class GenericoDineroProductos extends GenericoProductos
{

    function __construct()
    {
    parent::__construct();
    }


    protected $dinero;

    public function getDinero()
    {
    return $this->dinero;
    }




}



abstract class GenericoAlquiler extends GenericoDiaRepartidor
{

    function __construct()
    {
    parent::__construct();
    $this->alquileres = new Alquileres();
    }

    public function have()
    {
    return $this->alquileres->have();
    }

    protected $alquileres;

    public function getAlquileres()
    {
    return $this->alquileres;
    }

    public function setAlquileres($alquileres)
    {
    return $this->alquileres = $alquileres;
    }

}


abstract class GenericoDineroAlquiler extends GenericoAlquiler
{

    function __construct()
    {
    parent::__construct();
    }


    protected $dinero;

    public function getDinero()
    {
    return $this->dinero;
    }




}







?>
