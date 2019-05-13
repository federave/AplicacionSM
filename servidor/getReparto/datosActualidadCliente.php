<?php


include_once('funcionesDatosCliente.php');


function datosActualidadCliente(&$xml,$idCliente,$idDireccion,$fecha)
{
datosBasicos($xml,$idCliente);
datosDireccion($xml,$idDireccion);
datosBidonesDispenserFC($xml,$idCliente,$fecha);
$alquiler = datosAlquiler($xml,$idCliente,$fecha);
datosInactividad($xml,$idCliente,$idDireccion,$fecha,$alquiler);
preciosProductos($xml,$idCliente,$fecha);
}






?>
