<?php
include_once('../modelo/trabajadores/repartidores.php');
include_once('../modelo/trabajadores/vendedores.php');
include_once('../modelo/cliente/tipoClientes.php');
include_once('../modelo/cliente/tipoVisitas.php');
include_once('../modelo/cliente/tipoInactivos.php');
include_once('../modelo/diaRepartidor/repartos/reparto/fueraDeRecorrido/tipoFueraDeRecorrido.php');
include_once('../modelo/diaRepartidor/repartos/reparto/fueraDeRecorrido/tiposFueraDeRecorrido.php');

include_once('../otros/otros.php');



function agregarRepartidores(&$xml)
{
$repartidores = new Repartidores();
$xml->startTag("Repartidores");
$k=0;
while($k <   $repartidores->getNumeroRepartidores())
    {
    $repartidor = $repartidores->getRepartidor($k);
    $xml->startTag("Repartidor");
      $xml->addTag("IdRepartidor",$repartidor->getId());
      $xml->addTag("NombreRepartidor",$repartidor->getNombre());
      $xml->addTag("ApellidoRepartidor",$repartidor->getApellido());
      $xml->addTag("DniRepartidor",$repartidor->getDni());
    $xml->closeTag("Repartidor");
    $k++;
    }
$xml->closeTag("Repartidores");
escribir($xml->toString());
}



function agregarVendedores(&$xml)
{
$vendedores = new Vendedores();
$xml->startTag("Vendedores");
$k=0;
while($k <  $vendedores->getNumeroVendedores())
    {
    $vendedor = $vendedores->getVendedor($k);
    $xml->startTag("Vendedor");
      $xml->addTag("IdVendedor",$vendedor->getId());
      $xml->addTag("NombreVendedor",$vendedor->getNombre());
      $xml->addTag("ApellidoVendedor",$vendedor->getApellido());
      $xml->addTag("DniVendedor",$vendedor->getDni());
    $xml->closeTag("Vendedor");
    $k++;
    }
$xml->closeTag("Vendedores");
escribir($xml->toString());

}

function agregarTipoClientes(&$xml)
{
$tipoClientes = new TipoClientes();
$xml->startTag("TipoClientes");
$k=0;
while($k < $tipoClientes->getNumeroTipoClientes())
    {
    $tipoCliente = $tipoClientes->getTipoCliente($k);
    $xml->startTag("TipoCliente");
      $xml->addTag("IdTipoCliente",$tipoCliente->getId());
      $xml->addTag("tipoCliente",$tipoCliente->getTipoCliente());
    $xml->closeTag("TipoCliente");
    $k++;
    }
$xml->closeTag("TipoClientes");
}

function agregarTipoVisitas(&$xml)
{
$tipoVisitas = new TipoVisitas();
$xml->startTag("TipoVisitas");
$k=0;
while($k < $tipoVisitas->getNumeroTipoVisitas())
    {
    $tipoVisita = $tipoVisitas->getTipoVisita($k);
    $xml->startTag("TipoVisita");
      $xml->addTag("IdTipoVisita",$tipoVisita->getId());
      $xml->addTag("tipoVisita",$tipoVisita->getTipoVisita());
    $xml->closeTag("TipoVisita");
    $k++;
    }
$xml->closeTag("TipoVisitas");
}

function agregarTipoInactivos(&$xml)
{
$tipoInactivos = new TipoInactivos();
$xml->startTag("TipoInactivos");
$k=0;
while($k < $tipoInactivos->getNumeroTipoInactivos())
    {
    $tipoInactivo = $tipoInactivos->getTipoInactivo($k);
    $xml->startTag("TipoInactivo");
      $xml->addTag("IdTipoInactivo",$tipoInactivo->getId());
      $xml->addTag("tipoInactivo",$tipoInactivo->getTipoInactivo());
    $xml->closeTag("TipoInactivo");
    $k++;
    }
$xml->closeTag("TipoInactivos");
}


function agregarTiposFueraDeRecorrido(&$xml)
{
$tiposFueraDeRecorrido = new TiposFueraDeRecorrido();
$xml->startTag("TiposFueraDeRecorrido");
$k=0;
while($k < $tiposFueraDeRecorrido->getNumero())
    {
    $tipoFueraDeRecorrido = $tiposFueraDeRecorrido->getTipo($k);
    $xml->startTag("TipoFueraDeRecorrido");
      $xml->addTag("IdTipoFueraDeRecorrido",$tipoFueraDeRecorrido->getId());
      $xml->addTag("tipoFueraDeRecorrido",$tipoFueraDeRecorrido->getTipo());
    $xml->closeTag("TipoFueraDeRecorrido");
    $k++;
    }
$xml->closeTag("TiposFueraDeRecorrido");
}


//////// Script que se ejecuta


$xml = new Xml();
$xml->startTag("ActualizarBaseDeDatos");
  agregarRepartidores($xml);
  agregarVendedores($xml);
  agregarTipoClientes($xml);
  agregarTipoVisitas($xml);
  agregarTipoInactivos($xml);
  agregarTiposFueraDeRecorrido($xml);

$xml->closeTag("ActualizarBaseDeDatos");
echo $xml->toString();

?>
