<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/AplicacionSM/modelo/conector.php');

function redirect($url, $statusCode = 303)
{
header('Location: ' . $url, true, $statusCode);
die();
}

function boolToString($valor)
{
  if($valor)
    return "true";
  else
    return "false";
}



function escribir($texto)
{
$conector = new Conector();
if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();
  $sql = "INSERT INTO Debug(debug)VALUES('$texto')";
  $conexion->query($sql);
  $conector->cerrarConexion();
  }
}


class Xml
{

  function __construct()
  {
  }

  protected $xml = "";

  public function startTag($nombreTag)
  {
  $this->xml .= "<" . $nombreTag . ">";
  }

  public function closeTag($nombreTag)
  {
  $this->xml .= "</" . $nombreTag . ">";
  }
  public function addValue($valor)
  {
  $this->xml .= $valor;
  }
  public function addTag($nombreTag,$valor)
  {
  $this->startTag($nombreTag);
  $this->addValue($valor);
  $this->closeTag($nombreTag);
  }

  public function getXML(){return $this->xml;}

  public function toString(){return $this->xml;}



}



class Item
{

  function __construct()
  {
  }

  private $titulo="";
  private $descripcion="";
  private $descripcionOculta="";
  private $id=0;

  public function getId(){return $this->id;}

  public function getTitulo(){return $this->titulo;}
  public function getDescripcion(){return $this->descripcion;}
  public function getDescripcionOculta(){return $this->descripcionOculta;}

  public function setId($id){return $this->id = $id;}
  public function setTitulo($titulo){return $this->titulo = $titulo;}
  public function setDescripcion($descripcion){return $this->descripcion = $descripcion;}
  public function setDescripcionOculta($descripcionOculta){return $this->descripcionOculta = $descripcionOculta;}




}


class Items
{

  function __construct()
  {
  }

  private $items=array();
  private $size=0;

  public function addItem($item)
  {
  $this->items[$this->size] = $item;
  $this->size++;
  }

  public function getItem($indice)
  {
  if($indice >= 0  && $indice < $this->size)
    return $this->items[$indice];
  else
    return null;
  }

  public function clear()
  {
  $this->items=array();
  $this->size=0;
  }

  public function getSize(){return $this->size;}




}







?>
