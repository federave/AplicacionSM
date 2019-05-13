<?php


include_once('funcionesDatosCliente.php');




function datosCliente(&$xml,$idCliente,$idDireccion,$fecha)
{

//escribir("");
//escribir("Testo 11 mayo");
//escribir("");

//$tiempoinicio = microtime(true);

$xml->startTag("DatosCliente");

$conector = new Conector();

if($conector->abrirConexion())
  {
  $conexion = $conector->getConexion();

  //$tiempo_inicio = microtime(true);
  datosBasicos($xml,$idCliente);
  //$tiempo_fin = microtime(true);
  //escribir("DatosBasicos: " . ($tiempo_fin - $tiempo_inicio));

  //$tiempo_inicio = microtime(true);
  datosDireccion($xml,$idDireccion);
  //$tiempo_fin = microtime(true);
  //escribir("DatosDireccion: " . ($tiempo_fin - $tiempo_inicio));

  //$tiempo_inicio = microtime(true);
  datosBidonesDispenserFC($xml,$idCliente,$fecha);
  //$tiempo_fin = microtime(true);
  //escribir("DatosBidonesDispenserFC: " . ($tiempo_fin - $tiempo_inicio));

  //$tiempo_inicio = microtime(true);
  $alquiler = datosAlquiler($xml,$idCliente,$fecha);
  //$tiempo_fin = microtime(true);
  //escribir("DatosAlquiler: " . ($tiempo_fin - $tiempo_inicio));

  //$tiempo_inicio = microtime(true);
  inactividad($xml,$idCliente,$idDireccion,$fecha,$alquiler);
  //$tiempo_fin = microtime(true);
  //escribir("DatosInactividad: " . ($tiempo_fin - $tiempo_inicio));

  //$tiempo_inicio = microtime(true);
  preciosProductos($xml,$idCliente,$fecha);
  //$tiempo_fin = microtime(true);
  //escribir("DatosPreciosProductos: " . ($tiempo_fin - $tiempo_inicio));


  $conector->cerrarConexion();
  }
$xml->closeTag("DatosCliente");

//$tiempofin = microtime(true);
//escribir("DatosCliente: " . ($tiempofin - $tiempoinicio));

}





 ?>
