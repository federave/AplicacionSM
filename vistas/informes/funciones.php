<?php


function diferenciaMeses($fechaInicio,$fechaFin)
{

$fechaAux = strtotime($fechaInicio);
$fechaAuxFin = strtotime($fechaFin);

$year = date("Y", $fechaAux);
$mes = date("m", $fechaAux);
$dia = date("d", $fechaAux);

$fechaAux = strtotime("1-".$mes."-".$year);

$cuenta=1;

$aux=true;
while($aux)
  {

  $fechaAux = strtotime("+1 month",$fechaAux);

  if($fechaAux>$fechaAuxFin)
    $aux=false;
  else
    $cuenta++;


  }


return $cuenta;
}






 ?>
