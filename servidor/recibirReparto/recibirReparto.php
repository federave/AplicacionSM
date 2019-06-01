<?php
include_once('../../otros/otros.php');
include_once('../../modelo/conector.php');
include_once('../../modelo/precios/precios.php');
include_once('precioProductos.php');
include_once('alquileres.php');
//include_once('bidonesCliente.php');
include_once('deudaProductos.php');
include_once('observaciones.php');
include_once('dispensadores.php');
include_once('visitas.php');
include_once('planilladinamica.php');


$idRepartidor = $_POST["idRepartidor"];
$fecha = $_POST["fecha"];


$reparto = new SimpleXMLElement($_POST["reparto"]);

$idCliente = $reparto->IdCliente;
$idDireccion = $reparto->IdDireccion;




$aux=true;

//Deudas Productos
$tiempo_inicio = microtime(true);
$aux&=eliminarDeudasProductos($idCliente,$idRepartidor,$fecha);
$aux&=actualizarDeudaProductos($reparto,$idCliente,$idRepartidor,$fecha);
$tiempo_fin = microtime(true);
escribir("Deudas Productos: " . ($tiempo_fin - $tiempo_inicio));

//Observaciones
$tiempo_inicio = microtime(true);
$aux&=eliminarObservaciones($idCliente,$idDireccion,$idRepartidor,$fecha);
$aux&=actualizarObservaciones($reparto,$idCliente,$idDireccion,$idRepartidor,$fecha);
$tiempo_fin = microtime(true);
escribir("Observaciones: " . ($tiempo_fin - $tiempo_inicio));

//Dispensadores
$tiempo_inicio = microtime(true);
$aux&=eliminarDispensadores($idCliente,$idDireccion,$idRepartidor,$fecha);
$aux&=actualizarDispensadores($reparto,$idCliente,$idDireccion,$idRepartidor,$fecha);
$tiempo_fin = microtime(true);
escribir("Dispensadores: " . ($tiempo_fin - $tiempo_inicio));

//Visitas
$tiempo_inicio = microtime(true);
$aux&=actualizarVisitas($reparto,$idCliente,$idDireccion,$idRepartidor,$fecha);
$tiempo_fin = microtime(true);
escribir("Visitas: " . ($tiempo_fin - $tiempo_inicio));

//Planilla Alquileres Bidones Cliente

$tiempo_inicio = microtime(true);
$aux&=actualizarPlanillaDinamica($reparto,$idCliente,$idDireccion,$idRepartidor,$fecha);
$tiempo_fin = microtime(true);
escribir("Planilla Total: " . ($tiempo_fin - $tiempo_inicio));


$xml = new Xml();
$xml->addTag("EstadoDatoDiaRecibido",$aux);
echo $xml->toString();




?>
