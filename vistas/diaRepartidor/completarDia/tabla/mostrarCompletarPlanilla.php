<?php
include_once('../../otros/otros.php');
include_once('../../modelo/diaRepartidor/diaRepartidor.php');
include_once('../../modelo/diaRepartidor/include.php');

session_start();


if (isset($_POST["idRepartidor_seleccionado"]))
  {


  $planillas = new Planillas($_POST["idRepartidor_seleccionado"],$_POST["fecha_seleccionado"]);

  $_SESSION["DiaRepartidor"]->setPlanillas($planillas);
  $_SESSION["DiaRepartidor"]->setMostrarCompletarDia(true);


  redirect('../../index.php');

  }




?>
